<?php
$this->assign('title', __('Users/View'));
$this->Html->addCrumb(__('Users'), ['controller' => 'Users', 'action' => 'index']);
$this->Html->addCrumb(__('View'));
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
                <div class="pull-right card-action">
                    <div class="btn-group" role="group" aria-label="...">
                        <?=$this->Html->link('<i class="fa fa-edit"></i>', ['controller' => 'Users', 'action' => 'edit', $user->id], ['escape' => false, 'class' => 'btn btn-warning'])?>&nbsp;
                        <?=$this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'Users', 'action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', h($user->full_name)), 'escape' => false, 'class' => 'btn btn-danger'])?>
                    </div>
                </div>
            </div>
            <div class="card-body no-padding">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td><?= __('Id')?></td>
                            <td><?= $this->Number->format($user->id)?></td>
                        </tr>
                        <tr>
                            <td><?= __('Role')?></td>
                            <td><?= $this->Html->link(h($user->role->name), ['controller' => 'Roles', 'action' => 'view', $user->role->id])?></td>
                        </tr>
                        <tr>
                            <td><?= __('Email')?></td>
                            <td><?= h($user->email)?></td>
                        </tr>
                        <tr>
                            <td><?= __('Full name')?></td>
                            <td><?= h($user->full_name)?></td>
                        </tr>
                        <tr>
                            <td><?= __('Status')?></td>
                            <td><?=$this->Form->postLink($user->status?__('Activated'):__('Disabled'), ['controller' => 'Users', 'action' => 'toggle', $user->id], ['class' => ($user->status?'btn btn-success btn-xs':'btn btn-warning btn-xs'), 'confirm' => __('Are you sure you want to change user status to "{0}"', ($user->status?__('Disabled'):__('Activated')))])?></td>
                        </tr>
                        <tr>
                            <td><?= __('Created')?></td>
                            <td><?= $user->created?></td>
                        </tr>
                        <tr>
                            <td><?= __('Modified')?></td>
                            <td><?= $user->modified?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- /End card -->
</div>