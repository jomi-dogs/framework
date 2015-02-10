<?php
/**
 * @var \framework\View $this
 * @var \Exception $e
 */
?>
<html>
<head>

</head>
<body>
<div>
    <span><?php echo $e->getCode()?> </span>
    <span><?php echo $e->getMessage()?></span>
</div>
<div>
    <?php
    $backtrace = debug_backtrace();
    var_dump($backtrace);
    ?>
</div>
</body>
</html>