<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/30/15
 * Time: 11:10 PM
 */

namespace framework;


use framework\modules\Db;
use framework\traits\DbTrait;

abstract class Migration {
    use DbTrait;

    /** @var  Db */
    public $db;
    /**
     * @return static
     */
    public function init()
    {
        $this->db = Core::$app->db;
        // TODO: Implement init() method.
    }

    public abstract function up();
    public abstract function down();
}