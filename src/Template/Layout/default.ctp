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
    <!-- Fonts -->
    <?=$this->Html->css('//fonts.googleapis.com/css?family=Roboto+Condensed:300,400')?>
    <?=$this->Html->css('//fonts.googleapis.com/css?family=Lato:300,400,700,900')?>
    <!-- CSS Libs -->
    <?=$this->Html->css('bootstrap.min')?>
    <?=$this->Html->css('font-awesome.min')?>
    <?=$this->Html->css('animate.min')?>
    <?=$this->fetch('css')?>
    <!-- CSS App -->
    <?=$this->Html->css('admin_style')?>
    <?=$this->Html->css('themes/flat-blue')?>
    <!--[if lt IE 9]>
        <?=$this->Html->script('html5shiv.min')?>
        <?=$this->Html->script('respond.min')?>
    <![endif]-->
</head>
<body class="flat-blue">
    <div class="app-container">
        <div class="row content-container">
            <?= $this->element('Admin/navbar_top')?>
            <?= $this->element('Admin/navbar_side')?>
            <div class="container-fluid">
                <div class="side-body">
                    <?=$this->Flash->render()?>
                    <?=$this->Flash->render('auth')?>
                    <?=$this->fetch('content')?>
                </div>
            </div>
            <!-- /. MAIN CONTENT  -->
        </div>
        <?= $this->element('Admin/footer')?>
        <!-- /. FOOTER  -->
    </div>

    <!--[if lt IE 9]>
        <?=$this->Html->script('jquery-1.12.3.min')?>
    <![endif]-->
    <!--[if (gte IE 9) | (!IE)]><!-->
        <?=$this->Html->script('jquery.min')?>
    <![endif]-->
    <?=$this->Html->script('bootstrap.min')?>
    <?=$this->Html->script('bootstrap-switch.min')?>
    <?=$this->Html->script('jquery.matchHeight-min')?>
    <?=$this->Html->script('app')?>
    <?=$this->fetch('script')?>
</body>
</html>
