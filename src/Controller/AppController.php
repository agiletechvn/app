<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Core\Setting;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->loadComponent('Auth', [
            'authorize' => [
                'TinyAuth.Tiny' => [
                    'multiRole' => false,
                    'autoClearCache' => Configure::read('debug'),
                ],
            ],
            'authenticate' => [
                'Authenticate.Advance' => [
                    'lockout' => [
                        'retries' => Setting::read('BruteForceProtection.retries'),
                        'expires' => Setting::read('BruteForceProtection.expires'),
                        'file_path' => Setting::read('BruteForceProtection.file_path'),
                    ],
                    'remember' => [
                        'enable' => Setting::read('Remember.enable'),
                        'key' => Setting::read('Remember.key'),
                        'expires' => Setting::read('Remember.expires'),
                    ],
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password',
                    ],
                    'scope' => ['Users.status' => true],
                ],
            ],
            'loginAction' => [
                'prefix' => 'admin',
                'controller' => 'Users',
                'action' => 'login',
            ],
            'loginRedirect' => [
                'prefix' => 'admin',
                'controller' => 'Dashboard',
                'action' => 'index',
            ],
            'logoutRedirect' => [
                'prefix' => 'admin',
                'controller' => 'Users',
                'action' => 'login',
            ],
            'unauthorizedRedirect' => false,
            'authError' => __('Did you really think you are allowed to see that?'),
        ]);
    }

    /**
     * beforeFilter method
     * Do automatic login
     * If cannot login, delete cookie
     * @param Cake\Event\Event $event event
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        //Automaticaly Login.
        if (!$this->Auth->user() && $this->Cookie->read(Setting::read('Remember.key'))) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
            } else {
                $this->Cookie->delete(Setting::read('Remember.key'));
            }
        }
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}
