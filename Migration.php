<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/30/15
 * Time: 11:10 PM
 */

namespace jf;


use jf\modules\Db;
use jf\traits\DbTrait;

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
    }

    public abstract function up();
    public abstract function down();
}