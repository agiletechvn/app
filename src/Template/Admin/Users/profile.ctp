<?php
$this->assign('title', __('Users') . '/' . __('Profile'));
$this->Html->addCrumb(__('Users'), ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'index']);
$this->Html->addCrumb(__('Profile'));
?>
<div class="row">
    <div class="col-lg-8 col-lg-offset-3 col-md-10 col-lg-offset-2 col-xs-12">
        <div class="card summary-inline">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">
                        <?= h($user->full_name) ?>
                    </div>
                </div>
            </div>
            <div class="card-body no-padding">
                <div role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?= __('Profile')?></a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?= __('Change password')?></a></li>
                        <li role="presentation"><?= $this->Form->postLink(__('Deactive account'), ['action' => 'deactive'], ['confirm' => __('Are you sure you want to deactive your account?'), 'style' => 'background: #DC2A26; color: #fff'])?></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <?php
                                echo $this->Form->create($user, ['templates' => 'template_form_1_column']);
                                echo $this->Form->input('action', ['type' => 'hidden', 'value' => 'edit_profile']);
                                echo $this->Form->input('id', ['type' => 'hidden']);
                                echo $this->Form->input('email',['readonly' => true]);
                                echo $this->Form->input('full_name');
                                echo $this->Form->button(__('Save'), ['class' => 'btn btn-primary', 'type' => 'submit']);
                                echo $this->Form->end();
                            ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <?php
                                echo $this->Form->create($user, ['templates' => 'template_form_1_column']);
                                echo $this->Form->input('action', ['type' => 'hidden', 'value' => 'change_password']);
                                echo $this->Form->input('id', ['type' => 'hidden']);
                                echo $this->Form->input('current_password', ['type' => 'password']);
                                echo $this->Form->input('password');
                                echo $this->Form->input('re_password', ['type' => 'password']);
                                echo $this->Form->button(__('Save'), ['class' => 'btn btn-primary', 'type' => 'submit']);
                                echo $this->Form->end();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /End card -->
</div>