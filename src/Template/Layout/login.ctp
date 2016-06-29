<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?=$this->Html->charset()?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>
        <?=$this->fetch('title')?>
    </title>
    <?=$this->Html->meta('icon')?>
    <?=$this->fetch('meta')?>
    <?=$this->Html->css('//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css')?>
    <?=$this->Html->css('login_style')?>
    <?=$this->fetch('css')?>
    <!--[if lt IE 9]>
        <?=$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js')?>
        <?=$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js')?>
    <![endif]-->
</head>
<body>
    <div class="container">
        <div class="logo">
            <?= $this->Html->image(App\Core\Setting::read('App.Logo'))?>
        </div>
        <?=$this->fetch('content')?>
    </div>
    <?=$this->fetch('script')?>
</body>
</html>
