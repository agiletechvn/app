<?php
$this->assign('title', __('Login'));
$templates = [
    'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
];
$this->layout = 'login';
?>
<?=$this->Form->create(null, ['templates' => $templates, 'class' => 'form-signin'])?>
    <?=$this->Flash->render()?>
    <?=$this->Flash->render('auth')?>
    <div class="control has-feedback">
        <?=$this->Form->input('email', ['label' => false, 'required' => true, 'class' => 'form-control', 'autofocus' => true, 'placeholder' => __('email')])?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="control has-feedback">
        <?=$this->Form->input('password', ['label' => false, 'required' => true, 'class' => 'form-control', 'placeholder' => __('password')])?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <?=$this->Form->input('RememberMe', ['checked' => false, 'type' => 'checkbox', 'id' => 'checkbox-2'])?>
    <?=$this->Form->input(__('Login'), ['type' => 'submit', 'class' => 'btn btn-primary'])?>
<?=$this->Form->end()?>
<dir class="action-link">
    <?=$this->Html->link(__('Lost password?'), ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'lostPassword'])?>
    <?=App\Core\Setting::read('Member.AnyoneCanRegister')?$this->Html->link(__('Register'), ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'register']):''?>
</dir>
