<nav class="navbar navbar-default navbar-fixed-top navbar-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-expand-toggle">
                <i class="fa fa-bars icon"></i>
            </button>
            <?=$this->Html->getCrumbList(['class' => 'breadcrumb navbar-breadcrumb', 'firstClass' => false, 'lastClass' => 'active'], ['text' => __('Dashboard'), 'url' => ['prefix' => 'admin', 'controller' => 'Dashboard', 'action' => 'index'], 'escape' => false])?>
            <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                <i class="fa fa-th icon"></i>
            </button>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                <i class="fa fa-times icon"></i>
            </button>
            <!-- <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-comments-o"></i></a>
                <ul class="dropdown-menu animated fadeInDown">
                    <li class="title">
                        Notification <span class="badge pull-right">0</span>
                    </li>
                    <li class="message">
                        No new notification
                    </li>
                </ul>
            </li> -->
            <!-- <li class="dropdown danger">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-star-half-o"></i> 4</a>
                <ul class="dropdown-menu danger  animated fadeInDown">
                    <li class="title">
                        Notification <span class="badge pull-right">4</span>
                    </li>
                    <li>
                        <ul class="list-group notifications">
                            <a href="#">
                                <li class="list-group-item">
                                    <span class="badge">1</span> <i class="fa fa-exclamation-circle icon"></i> new registration
                                </li>
                            </a>
                            <a href="#">
                                <li class="list-group-item">
                                    <span class="badge success">1</span> <i class="fa fa-check icon"></i> new orders
                                </li>
                            </a>
                            <a href="#">
                                <li class="list-group-item">
                                    <span class="badge danger">2</span> <i class="fa fa-comments icon"></i> customers messages
                                </li>
                            </a>
                            <a href="#">
                                <li class="list-group-item message">
                                    view all
                                </li>
                            </a>
                        </ul>
                    </li>
                </ul>
            </li> -->
            <li class="dropdown profile">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?=h($this->request->session()->read('Auth.User.full_name'))?> <span class="caret"></span></a>
                <ul class="dropdown-menu animated fadeInDown">
                    <li>
                        <div class="profile-info">
                            <h4 class="username"><?=h($this->request->session()->read('Auth.User.full_name'))?></h4>
                            <p><?=h($this->request->session()->read('Auth.User.email'))?></p>
                            <div class="btn-group margin-bottom-2x" role="group">
                                <?=$this->Html->link('<i class="fa fa-user"></i>&nbsp;' . __('Profile'), ['controller' => 'Users', 'action' => 'profile'], ['class' => 'btn btn-default', 'style' => 'margin-right: 5px', 'escape' => false])?>
                                <?=$this->Html->link('<i class="fa fa-sign-out"></i>&nbsp;' . __('Logout'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn btn-default', 'escape' => false])?>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
