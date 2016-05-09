<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?=$this->Html->charset()?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?=$this->fetch('title')?>
    </title>
    <?=$this->Html->meta('icon')?>
    <?=$this->fetch('meta')?>
    <?=$this->Html->css('bootstrap.min')?>
    <?=$this->Html->css('login_style')?>
    <?=$this->fetch('css')?>
    <!--[if lt IE 9]>
        <?=$this->Html->script('html5shiv.min')?>
        <?=$this->Html->script('respond.min')?>
    <![endif]-->
</head>
<body>
    <div class="container">
        <div class="logo">
            <?= $this->Html->image(Cake\Core\Configure::read('Meta.logo'))?>
        </div>
        <?=$this->fetch('content')?>
    </div>
    <?=$this->fetch('script')?>
</body>
</html>
