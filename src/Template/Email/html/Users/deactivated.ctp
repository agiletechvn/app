<?php
$this->assign('title', __('Your account has been deactivated'));
?>

Xin chào <b><?= h($user['full_name'])?></b>
<br/>
<strong>Tài khoản của bạn đã được khóa lại</strong>
<br/>
Bạn sẽ không thể tiếp tục đăng nhập vào hệ thống
<br/>
Nếu bạn đổi ý, hãy liên lạc trực tiếp với quản trị viên để được phục hồi tài khoản.
<?= $this->Html->link(__('Homepage'), $url)?>
