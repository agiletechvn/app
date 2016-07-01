<?php
$this->assign('title', __('Users/Edit'));
$this->Html->addCrumb(__('Users'), ['controller' => 'Users', 'action' => 'index']);
$this->Html->addCrumb(__('Edit'));
?>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">
                        <?= __('Edit User') ?>
                    </div>
                </div>
                <div class="pull-right card-action">
                    <div class="btn-group" role="group" aria-label="...">
                        <?=$this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', h($user->full_name)), 'escape' => false, 'class' => 'btn btn-danger'])?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->Form->create($user, ['templates' => 'template_form_1_column']) ?>
                    <?php
                        echo $this->Form->input('role_id', ['options' => $roles]);
                        echo $this->Form->input('email');
                        echo $this->Form->input('full_name');
                        echo $this->Form->input('password');
                        echo $this->Form->input('re_password', ['type' => 'password', 'required' => true, 'value' => $user->password]);
                        echo $this->Form->input('status');
                    ?>
                    <?= $this->Form->button(__('Update'), ['class' => 'btn btn-primary'], ['escape' => false, 'class' => 'btn btn-success'])?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
