<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/23/15
 * Time: 11:10 PM
 */

namespace framework\commands;


use framework\base\BaseMigrate;
use framework\Core;
use framework\Exception;
use framework\Migration;
use framework\traits\DbTrait;

class Migrate extends BaseMigrate
{
    use DbTrait;
    protected $tableName = 'migration_history';
    protected $migrations = array();
    protected $newMigrations = array();
    /**
     * @return array
     */
    protected function getNewMigrations()
    {
        $this->newMigrations = $this->migrations;
        foreach($this->migrationHistory as $key => $value) {
            unset($this->newMigrations[$value['name']]);
        }
        return $this->newMigrations;
    }

    /**
     * @param string $name
     *
     * @return Migration
     * @throws Exception
     */
    protected function getMigration($name)
    {
        $className='';
        foreach($this->migrations as $key => $migration) {
            if(strpos($key,$name) !== false){
                $className = $key;
                break;
            }
        }
        if(empty($className))
            throw new Exception("Migration $name  was not found", Core::EXCEPTION_ERROR_CODE);
        try{
            return $this->createMigration($className);
        } catch(Exception $e) {
            if($e->getCode() != Core::EXCEPTION_NOT_ERROR_CODE)
                throw $e;
        }
        throw new Exception("Migration $name was not found",Core::EXCEPTION_ERROR_CODE);
    }

    /**
     * @param $migrationKey
     *
     * @return mixed
     * @throws Exception
     * @internal param $name
     *
     */
    protected function createMigration($migrationKey)
    {
        if(empty($this->migrations[$migrationKey]))
            throw new Exception("There is no migration $migrationKey",Core::EXCEPTION_ERROR_CODE);
        if(file_exists($this->migrations[$migrationKey])){
            require_once($this->migrations[$migrationKey]);
            return new $migrationKey();
        }
        throw new Exception("File ".$this->migrations[$migrationKey].'.php could not be found', Core::EXCEPTION_NOT_ERROR_CODE);
    }

    protected function markMigration($name)
    {
        $this->insert($this->tableName,array(
            'name' => $name,
            'time' => gmdate('Y-m-d H:i:s')
        ));
        return true;
    }

    protected function unMarkMigration($name)
    {
        $this->delete($this->tableName,"name = ".$this->quote($name));
    }

    protected function init()
    {
        if(!$this->tableExists($this->tableName)) {
            $this->initialiseMigrationTable();
        }
        $sql = 'select * from migration_history order by time asc';
        $result = Core::$app->db->query($sql);
        if($result !== false)
            $this->migrationHistory = $result->fetchAll(\PDO::FETCH_ASSOC);
        $handle = opendir($this->migrationPath);
        while(($file = readdir($handle)) !== false) {
            if(substr($file,-4) != '.php')
                continue;
            $className = substr($file,0,-4);
            $this->migrations[$className] = $this->migrationPath.DIRECTORY_SEPARATOR.$file;
        }
    }

    private function initialiseMigrationTable()
    {
        $this->createTable($this->tableName,array(
            'time' => 'TIMESTAMP',
            'name' => 'varchar(255)',
        ));
        $this->markMigration('0000');
    }
}