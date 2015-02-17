<?php
/**
 * Created by PhpStorm.
 * User: macseem
 * Date: 2/18/15
 * Time: 1:05 AM
 *
 * @var array $brand
 * @var array $items
 */?>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=$brand['href']?>"><?=$brand['title']?>></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php foreach($items as $item): ?>
            <?=$item?>
            <?php endforeach; ?>
        </div><!-- /.navbar-collapse -->
    </div> <!-- /.container-fluid -->
</nav>