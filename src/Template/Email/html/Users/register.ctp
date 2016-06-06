<?php
$this->assign('title', __('Verify account'));
?>
<table>
    <tr>
        <td>
            <p>Xin chào <b><?= $user->email?></b>,</p>
            <p>Chúc mừng bạn đã đăng ký tài khoản thành công.</p>
            <h1>Tôi sẽ giúp bạn tạo mật khẩu mới và đăng nhập ngay bây giờ.</h1>
            <ol>Lưu ý
                <ul>
					<li>Yêu cầu này sẽ hết hạn vào "<?= $expired?>"</li>
					<li>Bạn cần phải hoàn tất kích hoạt tài khoản để bắt đầu sử dụng dịch vụ.</li>
                </ul>
            </ol>
            <p>Click vào link bên dưới để xác thực tài khoản.</p>
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <?= $this->Html->link(__('Reset password'), $this->Url->build(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'activeAccount', $token, urlencode($user->email)], ['full' => true]))?>
                    </td>
                </tr>
            </table>
            <!-- /button -->
        </td>
    </tr>
</table>
