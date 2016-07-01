<?php
$this->assign('title', __('Roles/Add'));
$this->Html->addCrumb(__('Roles'), ['controller' => 'Roles', 'action' => 'index']);
$this->Html->addCrumb(__('Add'));
?>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title"><?= __('Add Role') ?></div>
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
