<?php
$this->assign('title', __('Your password has been recovered successful'));
?>
<table>
    <tr>
        <td>
            <p><?= __('Hi <b>{0}</b>,', h($user->full_name))?></p>
            <h1><?= __('Your password has been recovered')?></h1>
            <p><?= __('You can login right now. Click button bellow')?></p>
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <?= $this->Html->link(__('Login'), $url)?>
                    </td>
                </tr>
            </table>
            <!-- /button -->
        </td>
    </tr>
</table>
