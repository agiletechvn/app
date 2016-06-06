<!DOCTYPE html>
<html>
<head>
    <?=$this->Html->charset()?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>
        <?=$this->fetch('title')?>
    </title>
    <?=$this->Html->meta('icon')?>
    <?=$this->fetch('meta')?>
    <?=$this->Html->css('bootstrap.min')?>
    <?=$this->Html->css('error_style')?>
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
