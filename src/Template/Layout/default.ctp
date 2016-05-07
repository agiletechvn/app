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
    <!-- Fonts -->
    <?=$this->Html->css('//fonts.googleapis.com/css?family=Roboto+Condensed:300,400')?>
    <?=$this->Html->css('//fonts.googleapis.com/css?family=Lato:300,400,700,900')?>
    <!-- CSS Libs -->
    <?=$this->Html->css('bootstrap.min.css')?>
    <?=$this->Html->css('font-awesome.min.css')?>
    <?=$this->Html->css('animate.min.css')?>
    <?=$this->fetch('css')?>
    <!-- CSS App -->
    <?=$this->Html->css('admin_style.css')?>
    <?=$this->Html->css('themes/flat-blue.css')?>

</head>
<body class="flat-blue">
    <div class="app-container">
        <div class="row content-container">
            <?= $this->element('navbar_top')?>
            <?= $this->element('navbar_side')?>
            <div class="container-fluid">
                <div class="side-body">
                    <?=$this->Flash->render()?>
                    <?=$this->Flash->render('auth')?>
                    <?=$this->fetch('content')?>
                </div>
            </div>
            <!-- /. MAIN CONTENT  -->
        </div>
        <?= $this->element('footer')?>
        <!-- /. FOOTER  -->
    </div>

    <?=$this->Html->script('jquery.min.js')?>
    <?=$this->Html->script('bootstrap.min.js')?>
    <?=$this->Html->script('bootstrap-switch.min.js')?>
    <?=$this->Html->script('jquery.matchHeight-min.js')?>
    <?=$this->Html->script('app.js')?>
    <?=$this->fetch('script')?>
</body>
</html>
