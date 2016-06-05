<?php
$this->assign('title', __('Verify account'));
?>
Xin chào <?= $user->email?>
<br/>
Chúc mừng bạn đã đăng ký tài khoản thành công.
<br/>
Tôi sẽ giúp bạn tạo mật khẩu mới và đăng nhập ngay bây giờ.
<br/>
<b>Lưu ý:</b>
<ul>
	<li>Yêu cầu này sẽ hết hạn vào "<?= $expired?>"</li>
	<li>Bạn cần phải hoàn tất kích hoạt tài khoản để bắt đầu sử dụng dịch vụ.</li>
</ul>
<br/>
Click vào link bên dưới để tạo mật khẩu mới.
<br/>
<?= $this->Html->link(__('Create password'), $this->Url->build(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'activeAccount', $token, urlencode($user->email)], ['full' => true]))?>
