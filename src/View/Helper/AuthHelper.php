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
     * getUser method
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

    /**
     * link method
     * @param string $title title
     * @param array|string $url url
     * @param array $options options
     * @param array $roles roles
     * @return string|bool
     */
    public function link($title, $url, array $options = [], array $roles = [])
    {
        if (empty($roles) || $this->hasRoles($roles)) {
            return $this->Html->link($title, $url, $options);
        }
        return false;
    }

    /**
     * postLink method
     * @param string $title title
     * @param array|string $url url
     * @param array $options options
     * @param array $roles roles
     * @return string|bool
     */
    public function postLink($title, $url = null, array $options = [], array $roles = [])
    {
        if (empty($roles) || $this->hasRoles($roles)) {
            return $this->Form->postLink($title, $url, $options);
        }
        return false;
    }
}
