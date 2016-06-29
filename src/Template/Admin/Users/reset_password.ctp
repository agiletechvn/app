<?php
$this->assign('title', __('Reset password'));
$this->layout = 'login';
$templates = [
    'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
];
?>
<?=$this->Form->create($user, ['templates' => $templates, 'class' => 'form-signin'])?>
    <?=$this->Flash->render()?>
	<?=$this->Flash->render('auth')?>
    <div class="control has-feedback">
        <?=$this->Form->input('email', ['label' => false, 'readonly' => true, 'class' => 'form-control', 'disabled' => true])?>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="control has-feedback">
	    <?=$this->Form->input('password', ['label' => false, 'required' => true, 'class' => 'form-control', 'autofocus' => true, 'placeholder' => __('Create password')])?>
	    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="control has-feedback">
	    <?=$this->Form->input('re_password', ['label' => false, 'required' => true, 'class' => 'form-control', 'type' => 'password', 'placeholder' => __('Repeat password')])?>
	    <span class="glyphicon glyphicon-retweet form-control-feedback"></span>
    </div>
    <?= $this->Form->input(__('Reset'), ['type' => 'submit', 'class' => 'btn btn-primary'])?>
<?=$this->Form->end()?>
<div class="action-link">
    <?= $this->Html->link(__('Login'), ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'login'])?>
    <?=App\Core\Setting::read('Member.AnyoneCanRegister')?$this->Html->link(__('Register'), ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'register']):''?>
</div>
