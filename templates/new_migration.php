<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 1/31/15
 * Time: 12:13 AM
 */

echo '<?php'.PHP_EOL;?>

use framework\Migration;

class <?php echo $name ?> extends Migration
{
    public function up()
    {
        echo 'Migration up';
        return true;
    }

    public function down()
    {
        echo 'Migration down';
        return false;
    }
}