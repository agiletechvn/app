<?php
$this->assign('title', __('Active account'));
$this->layout = 'FlatAdmin.login';
?>
<?=$this->Form->create($user, ['class' => 'form-signin'])?>
    <?=$this->Flash->render()?>
	<?=$this->Flash->render('auth')?>
    <div class="control has-feedback">
	    <?=$this->Form->input('full_name', ['label' => false, 'required' => true, 'class' => 'form-control', 'placeholder' => __('full name'), 'autofocus' => true])?>
	    <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="control has-feedback">
	    <?=$this->Form->input('password', ['label' => false, 'required' => true, 'class' => 'form-control', 'placeholder' => __('password')])?>
	    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="control has-feedback">
	    <?=$this->Form->input('re_password', ['label' => false, 'required' => true, 'class' => 'form-control', 'placeholder' => __('re_password'), 'type' => 'password'])?>
	    <span class="glyphicon glyphicon-retweet form-control-feedback"></span>
    </div>
    <?= $this->Form->input(__('Active'), ['type' => 'submit', 'class' => 'btn btn-primary'])?>
<?=$this->Form->end()?>
<dir class="action-link">
    <?= $this->Html->link(__('Login'), ['plugin' => 'FlatAdmin', 'controller' => 'Users', 'action' => 'login'])?>
    <?= $this->Html->link(__('Lost password?'), ['plugin' => 'FlatAdmin', 'controller' => 'Users', 'action' => 'lostPassword'])?>
</div>
