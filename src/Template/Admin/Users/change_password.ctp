<?php
use App\Core\Setting;

$this->assign('title', __('Users/Change password'));
$this->Html->addCrumb(__('Users'), ['controller' => 'Users', 'action' => 'index']);
$this->Html->addCrumb(__('Change password'));
?>
<div class="row">
    <div class="col-lg-8 col-lg-offset-3 col-md-10 col-lg-offset-2 col-xs-12">
        <div class="card summary-inline">
            <div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation">
                        <?= $this->Html->link(__('Profile'), ['action' => 'profile'])?>
                    </li>
                    <li role="presentation" class="active">
                        <?= $this->Html->link(__('Change password'), '#!')?>
                    </li>
                    <?php
                    if (Setting::read('Member.AnyoneCanDeactive')) {
                        echo '<li role="presentation">';
                        echo $this->Form->postLink(__('Deactive account'), ['action' => 'deactive'], ['confirm' => __('Are you sure you want to deactive your account?'), 'style' => 'background: #DC2A26; color: #fff']);
                        echo '</li>';
                    }
                    ?>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active card-body">
                        <?php
                            echo $this->Form->create($user, ['templates' => 'template_form_1_column']);
                            echo $this->Form->input('id', ['type' => 'hidden']);
                            echo $this->Form->input('current_password', ['type' => 'password', 'required' => true, 'autofocus' => true]);
                            echo $this->Form->input('password');
                            echo $this->Form->input('re_password', ['type' => 'password']);
                            echo $this->Form->button(__('Save'), ['class' => 'btn btn-primary', 'type' => 'submit']);
                            echo $this->Form->end();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /End card -->
</div>