<?php
$this->assign('title', __('Your account has been deactivated'));
?>
<table>
    <tr>
        <td>
            <p><?= __('Hi <b>{0}</b>,', h($user['full_name']))?></p>
            <h1><?= __('Your account has been deactivated')?></h1>
            <p><?= __('If you want to revert this action, please contact to Administrator')?></p>
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <?= $this->Html->link(__('Home page'), $url)?>
                    </td>
                </tr>
            </table>
            <!-- /button -->
        </td>
    </tr>
</table>
