<?php
$this->assign('title', __('Roles/Edit'));
$this->Html->addCrumb(__('Roles'), ['controller' => 'Roles', 'action' => 'index']);
$this->Html->addCrumb(__('Edit'));
?>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title"><?= __('Edit Role') ?></div>
                </div>
                <div class="pull-right card-action">
                    <div class="btn-group" role="group" aria-label="...">
                        <?=$this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', h($role->name)), 'escape' => false, 'class' => 'btn btn-danger'])?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->Form->create($role, ['templates' => 'template_form_1_column']) ?>
                    <?php
                        echo $this->Form->input('name');
                        echo $this->Form->input('alias');
                        echo $this->Form->input('description', ['type' => 'textarea']);
                    ?>
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
