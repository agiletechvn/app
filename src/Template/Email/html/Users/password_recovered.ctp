<?php
$this->assign('title', __('Your password has been recovered successful'));
?>
<table>
    <tr>
        <td>
            <p>Xin chào <b><?= h($user->full_name)?></b>,</p>
            <h1>Chúc mừng bạn đã lấy lại mật khẩu thành công.</h1>
            <p>Bạn có thể đăng nhập ngay bây giờ. Hãy click vào link bên dưới:</p>
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <?= $this->Html->link(__('Login'), $this->Url->build(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'login'], ['full' => true]))?>
                    </td>
                </tr>
            </table>
            <!-- /button -->
        </td>
    </tr>
</table>
