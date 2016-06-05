<?php
$this->assign('title', __('Your account has been verified successful'));
?>

Xin chào <b><?= h($user->full_name)?></b>
<br/>
<strong>Chúc mừng bạn đã kích hoạt tài khoản thành công</strong>
<br/>
Bạn có thể đăng nhập ngay bây giờ. Hãy click vào link bên dưới:
<br/>
<?= $this->Html->link(__('Login'), $this->Url->build(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'login'], ['full' => true]))?>
