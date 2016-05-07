<?php
$this->assign('title', __('Reset password'));
?>
Xin chào <b><?=h($user->full_name)?></b>
<br/>
Bạn đã quên mật khẩu ư?
<br/>
Tôi sẽ giúp bạn tạo mật khẩu mới và đăng nhập ngay bây giờ.
<br/>
<b>Lưu ý:</b>
<ul>
	<li>Yêu cầu này sẽ hết hạn vào "<?= $expired?>"</li>
	<li>Bạn vẫn có thể đăng nhập bằng mật khẩu hiện thời nếu bạn nhớ</li>
	<li>Bạn có thể bỏ qua email này nếu không muốn đặt lại mật khẩu</li>
</ul>
<br/>
Click vào link bên dưới để tạo mật khẩu mới.
<br/>
<?=$this->Html->link(__('Create password'), $url . '/admin/reset-password/' . $token . '/' . urlencode($user->email))?>