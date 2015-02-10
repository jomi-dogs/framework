<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 2/1/15
 * Time: 1:34 AM
 */

namespace framework\traits;


use framework\Core;
use framework\Exception;
use framework\helpers\DbHelper;

trait DbTrait {

    /**
     * @param string $name
     * @param array  $columns
     *
     * @return mixed
     * @throws Exception
     */
    function createTable($name, array $columns, array $keys = array()) {
        DbHelper::tableNameValidation($name);
        $sql = 'create table '.$name.'(';
        $expressions = array();
        foreach($columns as $columnName => $options) {
            $expressions[] = $columnName.' '.$options;
        }
        foreach($keys as $keyType => $keyOptions){
            $expressions[] = DbHelper::getKeyExpression($keyType,$keyOptions);
        }
        $sql.=join(', ',$expressions) . ')  ENGINE=InnoDB CHARACTER SET=UTF8;';
        return Core::$app->db->exec($sql);
    }

    function deleteTable($name)
    {
        DbHelper::tableNameValidation($name);
        $sql = 'drop table '.$name;
        $this->exec($sql);
    }


    public function exec($sql)
    {
        return Core::$app->db->exec($sql);
    }

    public function query($sql)
    {
        return Core::$app->db->query($sql);
    }

    public function insert($table,array $values)
    {
        return Core::$app->db->insert($table, $values);
    }

    public function update($table,array $values, $conditions = '')
    {
        return Core::$app->db->update($table,$values,$conditions);
    }

    public function  delete($table, $conditions)
    {
        return Core::$app->db->delete($table, $conditions);
    }

    public function createColumn($table, $columnName, $options)
    {
        $sql = 'alter '.$table.' add column '.$columnName.' '.$options;
        return $this->exec($sql);
    }

    public function deleteColumn($table,$columnName)
    {
        $sql = 'alter '.$table.' drop column '.$columnName.'';
        return $this->exec($sql);
    }

    public function tableExists($table)
    {
        $sql = <<<SQL
SHOW TABLES LIKE 'migration_history';
SQL;
        $result = Core::$app->db->query($sql);
        if($result === false){
            return false;
        }
        $row = $result->fetch(\PDO::FETCH_ASSOC);
        return !empty($row);
    }

    public function quote($str)
    {
        return Core::$app->db->pdo->quote($str);
    }
}