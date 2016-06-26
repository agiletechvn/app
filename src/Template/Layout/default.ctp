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
    <!-- Fonts -->
    <?=$this->Html->css('//fonts.googleapis.com/css?family=Roboto+Condensed:300,400')?>
    <?=$this->Html->css('//fonts.googleapis.com/css?family=Lato:300,400,700,900')?>
    <!-- CSS Libs -->
    <?=$this->Html->css('//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css')?>
    <?=$this->Html->css('//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css')?>
    <?=$this->Html->css('//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css')?>
    <?=$this->fetch('css')?>
    <!-- CSS App -->
    <?=$this->Html->css('admin_style.min')?>
    <?=$this->Html->css('themes/flat-blue.min')?>
    <!--[if lt IE 9]>
        <?=$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js')?>
        <?=$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js')?>
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
        <?=$this->Html->script('//code.jquery.com/jquery-1.12.4.min.js', ['integrity' => 'sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=', 'crossorigin' => 'anonymous'])?>
    <![endif]-->
    <!--[if (gte IE 9) | (!IE)]><!-->
        <?=$this->Html->script('//code.jquery.com/jquery-2.2.4.min.js', ['integrity' => 'sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=', 'crossorigin' => 'anonymous'])?>
    <![endif]-->
    <?=$this->Html->script('//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js')?>
    <?=$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js')?>
    <?=$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js')?>
    <?=$this->Html->script('app')?>
    <?=$this->fetch('script')?>
</body>
</html>
