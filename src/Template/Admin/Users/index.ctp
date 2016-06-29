<?php
$this->assign('title', __('Users'));
$this->Html->addCrumb(__('Users'));
$this->loadHelper('Search');

$this->Html->css('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker3.min.css', ['block' => true]);
$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js', ['block' => true]);
$this->Html->scriptBlock('
    $("#created").datepicker({autoclose: true,todayHighlight: true});
    $("#modified").datepicker({autoclose: true,todayHighlight: true});
', ['block' => true]);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">
                        <?=__('List')?>
                    </div>
                </div>
                <div class="pull-right card-action">
                    <div class="btn-group" role="group" aria-label="...">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false])?>&nbsp;
                        <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false])?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="actions"><?=__('Actions')?></th>
                            <th><?=$this->Paginator->sort('id')?></th>
                            <th><?=$this->Paginator->sort('role')?></th>
                            <th><?=$this->Paginator->sort('email')?></th>
                            <th><?=$this->Paginator->sort('full_name')?></th>
                            <th><?=$this->Paginator->sort('status')?></th>
                            <th><?=$this->Paginator->sort('created')?></th>
                            <th><?=$this->Paginator->sort('modified')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $this->Search->generate([
                            ['search', ['type' => 'submit', 'class' => 'btn btn-primary', 'style' => 'margin: 0px']],
                            ['id', ['placeholder' => __('id =')]],
                            ['role_id', ['empty' => __('All'), 'options' => $roles]],
                            ['email', ['placeholder' => __('email like')]],
                            ['full_name', ['placeholder' => __('full name like')]],
                            ['status', ['empty' => __('All'), 'options' => ['1' => __('Activated'), '0' => __('Disabled')]]],
                            ['created', ['placeholder' => __('created >=')]],
                            ['modified', ['placeholder' => __('modified <=')]],
                        ])?>
                        <?php
                        if($users->count() == 0):
                        ?>
                            <tr>
                                <td colspan="8" class="text-center"><?= __('No data found')?></td>
                            </tr>
                        <?php endif;?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <?=$this->Html->link('<i class="fa fa-search"></i>', ['action' => 'view', $user->id], ['escape' => false])?>&nbsp;
                                <?=$this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', $user->id], ['escape' => false])?>&nbsp;
                                <?=$this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', h($user->full_name)), 'escape' => false])?>
                            </td>
                            <td><?=$this->Number->format($user->id)?></td>
                            <td><?=$user->has('role') ? $this->Html->link(h($user->role->name), ['prefix' => 'admin', 'controller' => 'Roles', 'action' => 'view', $user->role->id]) : ''?></td>
                            <td><?=h($user->email)?></td>
                            <td><?=h($user->full_name)?></td>
                            <td><?=$this->Form->postLink($user->status ? __('Activated') : __('Disabled'), ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'toggle', $user->id], ['class' => ($user->status ? 'btn btn-success btn-xs' : 'btn btn-warning btn-xs'), 'confirm' => __('Are you sure you want to change user status to "{0}"', ($user->status ? __('Disabled') : __('Activated')))])?></td>
                            <td><?=$user->created?></td>
                            <td><?=$user->modified?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <ul class="pagination pagination-sm pull-right">
                    <?=$this->Paginator->prev()?>
                    <?=$this->Paginator->numbers()?>
                    <?=$this->Paginator->next()?>
                </ul>
                <p><?=$this->Paginator->counter()?></p>
            </div>
        </div>
    </div>
</div>
