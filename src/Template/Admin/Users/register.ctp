<?php
$this->assign('title', __('Register'));
$this->layout = 'login';
?>
<?=$this->Form->create($user, ['class' => 'form-signin'])?>
    <?=$this->Flash->render()?>
	<?=$this->Flash->render('auth')?>
    <div class="control has-feedback">
	    <?=$this->Form->input('email', ['label' => false, 'required' => true, 'class' => 'form-control', 'autofocus' => true, 'placeholder' => __('email')])?>
	    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <?=$this->Recaptcha->display()?>
    <?= $this->Form->input(__('Create account'), ['type' => 'submit', 'class' => 'btn btn-primary'])?>
<?=$this->Form->end()?>
<div class="action-link">
    <?= $this->Html->link(__('Login'), ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'login'])?>
    <?= $this->Html->link(__('Lost password?'), ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'lostPassword'])?>
</div>
