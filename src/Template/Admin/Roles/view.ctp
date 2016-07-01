<?php
$this->assign('title', __('Roles/View'));
$this->Html->addCrumb(__('Roles'), ['controller' => 'Roles', 'action' => 'index']);
$this->Html->addCrumb(__('View'));
?>
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title"><?= h($role->name) ?></div>
                </div>
                <div class="pull-right card-action">
                    <div class="btn-group" role="group" aria-label="...">
                        <?=$this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', $role->id], ['escape' => false, 'class' => 'btn btn-warning'])?>&nbsp;
                        <?=$this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', h($role->name)), 'escape' => false, 'class' => 'btn btn-danger'])?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <tr>
                        <td><?= __('Id') ?></td>
                        <td><?= $role->id ?></td>
                    </tr>
                    <tr>
                        <td><?= __('Name') ?></td>
                        <td><?= h($role->name) ?></td>
                    </tr>
                    <tr>
                        <td><?= __('Alias') ?></td>
                        <td><?= h($role->alias) ?></td>
                    </tr>
                    <tr>
                        <td><?= __('Description') ?></td>
                        <td><?= h($role->description) ?></td>
                    </tr>
                    <tr>
                        <td><?= __('Created') ?></td>
                        <td><?= $role->created ?></td>
                    </tr>
                    <tr>
                        <td><?= __('Modified') ?></td>
                        <td><?= $role->modified ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php if (!empty($role->users)): ?>
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title"><?= __('Related Users') ?></div>
                </div>
                <div class="pull-right card-action">
                    <div class="btn-group" role="group">
                        <?= $this->Number->format($role->users)?>&nbsp;<?= __('Users')?>
                    </div>
                </div>
            </div>
            <div class="card-body no-padding">
                <table class="table table-striped table-hover" cellspacing="0" width="100%">
                    <tr>
                        <th><?= __('Actions') ?></th>
                        <th><?= __('Id') ?></th>
                        <th><?= __('Email') ?></th>
                        <th><?= __('Full Name') ?></th>
                        <th><?= __('Status') ?></th>
                        <th><?= __('Created') ?></th>
                        <th><?= __('Modified') ?></th>
                    </tr>
                    <?php foreach ($role->users as $users): ?>
                    <tr>
                        <td>
                            <?=$this->Html->link('<i class="fa fa-search"></i>', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'view', $users->id], ['escape' => false])?>
                            <?=$this->Html->link('<i class="fa fa-edit"></i>', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'edit', $users->id], ['escape' => false])?>
                            <?=$this->Form->postLink('<i class="fa fa-trash"></i>', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', h($users->full_name)), 'escape' => false])?>
                        </td>
                        <td><?= h($users->id) ?></td>
                        <td><?= h($users->email) ?></td>
                        <td><?= h($users->full_name) ?></td>
                        <td><?=$this->Form->postLink($users->status?__('Activated'):__('Disabled'), ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'toggle', $users->id], ['class' => ($users->status?'btn btn-success btn-xs':'btn btn-warning btn-xs'), 'confirm' => __('Are you sure you want to change user status to "{0}"', ($users->status?__('Disabled'):__('Activated')))])?></td>
                        <td><?= h($users->created) ?></td>
                        <td><?= h($users->modified) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
