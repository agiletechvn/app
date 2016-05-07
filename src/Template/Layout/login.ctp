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
    <?=$this->Html->css('login_style')?>
    <?=$this->fetch('css')?>

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
