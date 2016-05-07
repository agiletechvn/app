<?php
use Cake\Core\Configure;
?>
<footer class="app-footer">
    <div class="wrapper">
        <span class="pull-right"><?= Configure::read('Meta.version')?>&nbsp;<a href="#"><i class="fa fa-long-arrow-up"></i></a></span>
        &copy;<?= Configure::read('Meta.copyright')?>
    </div>
</footer>
