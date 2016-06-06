<?php
$this->assign('title', __('Reset password'));
?>
<table>
    <tr>
        <td>
            <p>Xin chào <b><?=h($user->full_name)?></b>,</p>
            <p>Bạn đã quên mật khẩu ư?</p>
            <h1>Tôi sẽ giúp bạn tạo mật khẩu mới và đăng nhập ngay bây giờ.</h1>
            <ol>Lưu ý
                <ul>
                    <li>Yêu cầu này sẽ hết hạn vào "<?= $expired?>"</li>
                    <li>Bạn vẫn có thể đăng nhập bằng mật khẩu hiện thời nếu bạn nhớ</li>
                    <li>Bạn có thể bỏ qua email này nếu không muốn đặt lại mật khẩu</li>
                </ul>
            </ol>
            <p>Click vào link bên dưới để tạo mật khẩu mới.</p>
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <?= $this->Html->link(__('Reset password'), $this->Url->build(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'resetPassword', $token, urlencode($user->email)], ['full' => true]))?>
                    </td>
                </tr>
            </table>
            <!-- /button -->
        </td>
    </tr>
</table>
