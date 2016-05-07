<!DOCTYPE html>
<html>
<head>
    <?=$this->Html->charset()?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?=$this->fetch('title')?>
    </title>
    <?=$this->Html->meta('icon')?>
    <?=$this->fetch('meta')?>
    <?=$this->Html->css('bootstrap.min')?>
    <?=$this->Html->css('font-awesome.min')?>
    <?=$this->Html->css('style_error')?>
    <?=$this->fetch('css')?>
</head>
<body>
    <div class="container">
        <div class="content">
            <?=$this->fetch('content')?>
        </div>
    </div>
    <?=$this->fetch('script')?>
</body>
</html>
