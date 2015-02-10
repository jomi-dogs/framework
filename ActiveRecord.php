<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/23/15
 * Time: 11:08 PM
 */

namespace framework;


use framework\helpers\DbHelper;
use framework\interfaces\IActiveRecord;

abstract class ActiveRecord implements IActiveRecord{
    const EXCEPTION_NOT_VALID_ROW = 2000;

    /** @var modules\Db  */
    public $db;
    public $isNew;
    protected $attributes = array();

    public function __construct()
    {
        $this->attributes = array_flip($this->getAttributeNames());
        foreach($this->attributes as &$attribute)
            $attribute = NULL;
        $this->db = Core::$app->db;
        $this->isNew = true;
    }

    public function __set($name, $value)
    {
        if(isset($this->{'_'.$name}))
            $this->{'_'.$name} = $value;
        else
            $this->attributes[$name] = $value;
    }

    public function __get($name){
        if(isset($this->{'_'.$name}))
            return $this->{'_'.$name};
        $callable = array($this,'get'.ucfirst($name));
        if(is_callable($callable))
            return call_user_func($callable);
        if(isset($this->attributes[$name]))
            return $this->attributes[$name];
        return NULL;
    }

    /**
     * @return string
     */
    public abstract function getTable();

    /**
     * @return array
     */
    public abstract function getAttributeNames();
    /**
     * @return array
     */
    public abstract function getRequiredFields();

    /**
     * @return array ( $keyName )
     */
    public abstract function getPrimaryKeys();

    /**
     * @return array
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * @throws \Exception
     * @return bool
     */
    public function save()
    {
        if($this->isNew){
            $insertResult = $this->db->insert($this->getTable(),$this->getAttributes());
            $this->isNew = false;
            $this->setPrimary($insertResult);
            return $insertResult;
        }
        $conditions = array();
        $primary = $this->getPrimaryKeys();
        foreach($primary as $key)
            $conditions[] = $this->db->pdo->quote($key).'='.$this->db->pdo->quote($this->$key);
        $conditions = join(', ',$conditions);
        return $this->db->update($this->getTable(), $this->getAttributes(),$conditions);
    }

    /**
     * @param string $conditions
     *
     * @return static;
     * @throws Exception
     */
    public function findOne($conditions)
    {
        $sql = "select * from {$this->getTable()} ". DbHelper::getConditions($conditions) . ' limit 1';
        $row = $this->db->query($sql);
        if(!$row){
            throw new Exception('Something were wrong, result fail', static::EXCEPTION_NOT_VALID_ROW);
        }
        $row = $row->fetch(\PDO::FETCH_ASSOC);
        if(empty($row) || !is_array($row))
            throw new Exception('Something were wrong, fetch fail', static::EXCEPTION_NOT_VALID_ROW);
        foreach($row as $key => $value) {
            $this->$key = $value;
        }
        $this->isNew = false;
        return $this;
    }

    /**
     * @param string $column
     * @param        $value
     *
     * @return static
     * @throws Exception
     */
    public function findOneBy($column,$value)
    {
        $column = trim($this->db->pdo->quote($column),"'");
        $value = $this->db->pdo->quote($value);
        $conditions = "$column = $value";
        return $this->findOne($conditions);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($conditions)
    {
        //TODO: implement it
        return array();
    }

    public function fillFromRequest()
    {
        foreach($this->getAttributeNames() as $attribute) {
            try{
                $this->$attribute = $this->tryGetValueFromRequest($attribute);
            } catch(Exception $e) {
                if($e->getCode() == Core::EXCEPTION_NOT_ERROR_CODE){
                    if($this->isRequired($attribute))
                        throw new Exception("Attribute $attribute is required",Core::EXCEPTION_ERROR_CODE,$e);
                    continue;
                }
            }
        }
    }

    protected function tryGetValueFromRequest($attribute)
    {
        $request = Core::$app->request;
        if(!empty($request->get[$attribute])) {
            return $request->get[$attribute];
        }
        if(!empty($request->post[$attribute])) {
            return $request->post[$attribute];
        }
        if(!empty($this->$attribute))
            return $this->$attribute;
        throw new Exception("Can't find $attribute", Core::EXCEPTION_NOT_ERROR_CODE);
    }

    /**
     * @param string $attribute
     *
     * @return bool
     */
    public function isRequired($attribute)
    {
        return in_array($attribute,$this->getRequiredFields());
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected abstract function setPrimary($value);
}