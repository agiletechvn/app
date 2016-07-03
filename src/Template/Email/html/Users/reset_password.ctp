<?php
$this->assign('title', __('Reset password'));
?>
<table>
    <tr>
        <td>
            <p><?= __('Hi <b>{0}</b>', h($user->full_name))?></p>
            <h1><?= __('Did you forgot your password. We can create a new password right now')?></h1>
            <ol><?= __('Attention')?>
                <ul>
                    <li><?= __('This request will expired on {0}', $expired)?></li>
                    <li><?= __('Current password still valid until changed')?></li>
                    <li><?= __('Ignore this email if you dont want to change')?></li>
                </ul>
            </ol>
            <p><?= __('Click button bellow')?></p>
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <?= $this->Html->link(__('Reset password'), $url)?>
                    </td>
                </tr>
            </table>
            <!-- /button -->
        </td>
    </tr>
</table>
