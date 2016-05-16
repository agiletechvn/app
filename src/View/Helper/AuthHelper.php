<?php

namespace App\View\Helper;

use App\Auth\AuthUserTrait;
use Cake\Network\Exception\UnauthorizedException;
use Cake\View\Helper;

/**
 * Helper to access auth user data, generate link, postLink with checking roles
 *
 */
class AuthHelper extends Helper
{
    use AuthUserTrait;
    public $helpers = ['Html', 'Form'];

    /**
     * AuthUserHelper::_getUser()
     *
     * @return array
     */
    protected function _getUser()
    {
        if (!$this->request->session()->read('Auth.User')) {
            throw new UnauthorizedException(__('You can check after user signed in.'));
        }
        return $this->request->session()->read('Auth.User');
    }

    public function link($title, $url, array $options = array(), array $roles = array())
    {
        if (empty($roles) || $this->hasRoles($roles)) {
            return $this->Html->link($title, $url, $options);
        }
        return false;
    }

    public function postLink($title, $url = null, array $options = array(), array $roles = array())
    {
        if (empty($roles) || $this->hasRoles($roles)) {
            return $this->Form->postLink($title, $url, $options);
        }
        return false;
    }
}
