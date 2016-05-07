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
    <?=$this->Html->css('FlatAdmin.bootstrap.min.css')?>
    <?=$this->Html->css('FlatAdmin.font-awesome.min.css')?>
    <?=$this->Html->css('FlatAdmin.animate.min.css')?>
    <?=$this->fetch('css')?>
    <!-- CSS App -->
    <?=$this->Html->css('FlatAdmin.admin_style.css')?>
    <?=$this->Html->css('FlatAdmin.themes/flat-blue.css')?>

</head>
<body class="flat-blue">
    <div class="app-container">
        <div class="row content-container">
            <?= $this->element('FlatAdmin.navbar_top')?>
            <?= $this->element('FlatAdmin.navbar_side')?>
            <div class="container-fluid">
                <div class="side-body">
                    <?=$this->Flash->render()?>
                    <?=$this->Flash->render('auth')?>
                    <?=$this->fetch('content')?>
                </div>
            </div>
            <!-- /. MAIN CONTENT  -->
        </div>
        <?= $this->element('FlatAdmin.footer')?>
        <!-- /. FOOTER  -->
    </div>

    <?=$this->Html->script('FlatAdmin.jquery.min.js')?>
    <?=$this->Html->script('FlatAdmin.bootstrap.min.js')?>
    <?=$this->Html->script('FlatAdmin.bootstrap-switch.min.js')?>
    <?=$this->Html->script('FlatAdmin.jquery.matchHeight-min.js')?>
    <?=$this->Html->script('FlatAdmin.app.js')?>
    <?=$this->fetch('script')?>
</body>
</html>
