<?php
$this->assign('title', __('Verify account'));
?>
<table>
    <tr>
        <td>
            <p><?= __('Hi <b>{0}</b>,', $user->email)?></p>
            <h1><?= __('Thank you for join in. Please create password to completed verify account')?></h1>
            <ol><?= __('Attention')?>
                <ul>
                    <li><?= __('This request will expired on {0}', $expired)?></li>
                    <li><?= __('You have to completed verify account to start using service')?></li>
                </ul>
            </ol>
            <p><?= __('Click button bellow')?></p>
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <?= $this->Html->link(__('Create password'), $url)?>
                    </td>
                </tr>
            </table>
            <!-- /button -->
        </td>
    </tr>
</table>
