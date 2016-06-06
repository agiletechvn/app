<?php
$this->assign('title', __('Your account has been deactivated'));
?>
<table>
    <tr>
        <td>
            <p>Xin chào <b><?= h($user['full_name'])?></b>,</p>
            <h1>Tài khoản của bạn đã vô hiệu hóa</h1>
            <p>Bạn sẽ không thể tiếp tục đăng nhập vào hệ thống</p>
            <p><i>Nếu bạn đổi ý, hãy liên lạc trực tiếp với quản trị viên để được phục hồi tài khoản.</i></p>
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <?= $this->Html->link(__('Login'), $this->Url->build('/', ['full' => true]))?>
                    </td>
                </tr>
            </table>
            <!-- /button -->
        </td>
    </tr>
</table>
