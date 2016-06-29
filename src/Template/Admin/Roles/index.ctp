<?php
$this->assign('title', __('Roles'));
$this->Html->addCrumb(__('Roles'));
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
                            <th><?=__('id')?></th>
                            <th><?=__('alias')?></th>
                            <th><?=__('name')?></th>
                            <th><?=__('description')?></th>
                            <th><?=__('created')?></th>
                            <th><?=__('modified')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $this->Search->generate([
                            ['search', ['type' => 'submit', 'class' => 'btn btn-primary', 'style' => 'margin: 0px']],
                            ['id', ['placeholder' => __('id =')]],
                            ['alias', ['placeholder' => __('alias like')]],
                            ['name', ['placeholder' => __('name like')]],
                            ['description', ['placeholder' => __('description like')]],
                            ['created', ['placeholder' => __('created >=')]],
                            ['modified', ['placeholder' => __('modified <=')]],
                        ])?>
                        <?php
                        if($roles->count() == 0):
                        ?>
                            <tr>
                                <td colspan="7" class="text-center"><?= __('No data found')?></td>
                            </tr>
                        <?php endif;?>
                        <?php foreach ($roles as $role): ?>
                        <tr>
                            <td>
                                <?=$this->Html->link('<i class="fa fa-search"></i>', ['action' => 'view', $role->id], ['escape' => false])?>&nbsp;
                                <?=$this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', $role->id], ['escape' => false])?>&nbsp;
                                <?=$this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', h($role->name)), 'escape' => false])?>
                            </td>
                            <td><?=h($role->id)?></td>
                            <td><?=h($role->alias)?></td>
                            <td><?=h($role->name)?></td>
                            <td><?=h($role->description)?></td>
                            <td><?=$role->created?></td>
                            <td><?=$role->modified?></td>
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
