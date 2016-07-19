<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Core\Setting;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Security;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * initialize
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => ['index'],
        ]);

        //Allow guest to access this area
        $this->Auth->allow(['lostPassword', 'register', 'activeAccount', 'resetPassword', 'login']);

        if (in_array($this->request->action, [
            'lostPassword',
            'register',
            'activeAccount',
            'resetPassword',
            'login',
        ])) {
            $this->loadComponent('Csrf');
            $this->loadComponent('Recaptcha');
        }
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles'],
        ];
        $users = $this->paginate($this->Users->find('search', $this->Users->filterParams($this->request->query)));
        $roles = $this->Users->Roles->find('list');
        $this->set(compact('users', 'roles'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, ['contain' => ['Roles']]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $roles = $this->Users->Roles->find('list');
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, ['contain' => ['Roles']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                if ($id == $this->Auth->user('id')) {
                    $userSession = $this->Users->get($user->id)->toArray();
                    unset($userSession['password']);
                    $this->Auth->setUser($userSession);
                }
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $roles = $this->Users->Roles->find('list');
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to referer
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Toggle method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to referer
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function toggle($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        if ($this->Auth->user('id') == $id) {
            $this->Flash->error(__('Cannot change status your self.'));

            return $this->redirect($this->referer());
        }
        $user = $this->Users->get($id);
        $statusText = $user->status ? __('Disabled') : __('Activated');
        $user->status = !$user->status;
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been changed status to {0}.', $statusText));
        } else {
            $this->Flash->error(__('The user could not change status to {0}. Please, try again.', $statusText));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Profile method
     *
     * @return \Cake\Network\Response|null Redirects to referer
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function profile()
    {
        $user = $this->Users->get($this->Auth->user('id'), [
            'contain' => ['Roles'],
        ]);
        unset($user->password);
        if ($this->request->is(['post', 'put', 'patch'])) {
            $allowedToChange = ['full_name'];
            $data = array_intersect_key($this->request->data, array_flip($allowedToChange));
            $user = $this->Users->patchEntity($user, $data, ['validate' => 'EditProfile']);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your profile has been updated'));
                $userSession = $this->Users->get($user->id)->toArray();
                unset($userSession['password']);
                $this->Auth->setUser($userSession);

                return $this->redirect([]);
            } else {
                $this->Flash->error(__('The profile could not update. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * changePassword method
     *
     * @return \Cake\Network\Response|null Redirects
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function changePassword()
    {
        $user = $this->Users->get($this->Auth->user('id'), [
            'contain' => ['Roles'],
        ]);
        unset($user->password);
        if ($this->request->is(['post', 'put', 'patch'])) {
            $allowedToChange = ['password', 'current_password', 're_password'];
            $data = array_intersect_key($this->request->data, array_flip($allowedToChange));
            $user = $this->Users->patchEntity($user, $data, ['validate' => 'EditPassword']);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your password has been updated'));
                if (is_array($this->Cookie->read('CookieAuth'))) {
                    $this->Cookie->configKey('CookieAuth', [
                        'expired' => Setting::readOrFail('Member.RememberCookieExpired'),
                        'domain' => $this->request->host(),
                        'httpOnly' => !$this->request->is('ssl'),
                        'secure' => $this->request->is('ssl')]);
                    $this->Cookie->write('CookieAuth', [
                        'password' => $this->request->data['re_password'],
                    ]);
                }

                return $this->redirect([]);
            } else {
                $this->Flash->error(__('The password could not be change'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Deactive method
     *
     * @return \Cake\Network\Response|null Redirects to referer
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deactive()
    {
        $this->request->allowMethod(['post', 'put']);
        if (!Setting::read('Member.AnyoneCanDeactive')) {
            throw new NotFoundException(__('Page not found'));
        }
        if ($this->Users->deactive($this->Auth->user('id'))) {
            $url = Router::url([
                    'prefix' => 'admin',
                    'controller' => 'Users',
                    'action' => 'login',
                    '_full' => true,
                ]);
            TableRegistry::get('EmailQueue')
                ->enqueue($this->Auth->user('email'), [
                    'user' => $this->Auth->user(),
                    'url' => $url
                ], [
                    'subject' => __('Your account has been deactivated'),
                    'template' => 'Users/deactivated',
                    'format' => 'html',
                    'layout' => 'default']);

                return $this->redirect(['action' => 'logout']);
        }
        $this->Flash->error(__('Unable to deactive your account. Please try again or contact to your administrator'));

        return $this->redirect($this->referer());
    }

    /**
     * Login function
     * @return Cake\Network\Response
     */
    public function login()
    {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->Flash->success(__('Login successful'));

                //Write to cookie if Remember me is checked
                if ((bool)$this->request->data['RememberMe']) {
                    $this->Cookie->configKey('CookieAuth', [
                        'expired' => Setting::readOrFail('Member.RememberCookieExpired'),
                        'domain' => $this->request->host(),
                        'httpOnly' => !$this->request->is('ssl'),
                        'secure' => $this->request->is('ssl')]);
                    $this->Cookie->write('CookieAuth', [
                        'email' => $user['email'],
                        'password' => $this->request->data['password']]);
                }

                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Login failed. Please check your email, password'));
        }
    }

    /**
     * Logout function
     * @return Cake\Network\Response
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Password recovery
     * $token hash from $user->email . $user->token_created . $user->id
     * @return Cake\Network\Response
     */
    public function lostPassword()
    {
        if ($this->request->is('post')) {
            if ($this->Recaptcha->verify()) {
                $tokenData = $this->Users->createToken($this->request->data['email'], true, Setting::readOrFail('Member.ResetPasswordTokenExpired'));
                if ($tokenData) {
                    $url = Router::url([
                            'prefix' => 'admin',
                            'controller' => 'Users',
                            'action' => 'resetPassword',
                            $tokenData['token'],
                            $tokenData['user']->email,
                            '_full' => true,
                        ]);
                    TableRegistry::get('EmailQueue')
                        ->enqueue($tokenData['user']->email, [
                                'user' => $tokenData['user'],
                                'expired' => $tokenData['expired']->i18nFormat(),
                                'url' => $url
                            ], [
                                'subject' => __('Reset Password'),
                                'template' => 'Users/reset_password',
                                'format' => 'html',
                                'layout' => 'default'
                            ]);
                    $this->Flash->success(__('Please check your email to create a new password.'));

                    return $this->redirect(['action' => 'login']);
                }
                $this->Flash->error(__('Email does not exist/inactive. Please try again!'));
            } else {
                $this->Flash->error(__('Please pass Google Recaptcha first'));
            }
        }
    }

    /**
     * Reset password
     * @param string $token hash from $user->email . $user->token_created . $user->id
     * @param string $email email
     * @return Cake\Network\Response
     */
    public function resetPassword($token = null, $email = null)
    {
        if (!$token || !$email) {
            throw new NotFoundException(__('Missing required information. Please read email carefully and try again!'));
        }
        $user = $this->Users->findByEmailAndStatus($email, true)->first();
        if (!$user) {
            throw new RecordNotFoundException(__('Account not found. Please read email carefully and try again!'));
        }
        if ($token != Security::hash($user->email . $user->token_created . $user->id, 'sha1', true)) {
            throw new ForbiddenException(__('Invalid token. Please read email carefully and try again!'));
        }

        if (!$user->token_created->wasWithinLast(Setting::readOrFail('Member.ResetPasswordTokenExpired'))) {
            $this->Flash->error(__('Your request has been expired. Please create a new request!'));

            return $this->redirect(['action' => 'lostPassword']);
        }
        unset($user->password);
        if ($this->request->is('put')) {
            $allowedToChange = ['password', 're_password'];
            $data = array_intersect_key($this->request->data, array_flip($allowedToChange));
            $user = $this->Users->patchEntity($user, $data, ['validate' => 'ResetPassword']);
            $user->token_created = null;
            if ($this->Users->save($user)) {
                unset($user->password);
                $url = Router::url([
                        'prefix' => 'admin',
                        'controller' => 'Users',
                        'action' => 'login',
                        '_full' => true,
                    ]);
                TableRegistry::get('EmailQueue')
                    ->enqueue($user->email, [
                        'user' => $user,
                        'url' => $url
                    ], [
                        'subject' => __('Your password has been recovered'),
                        'template' => 'Users/password_recovered',
                        'layout' => 'default',
                        'format' => 'html'
                    ]);
                $this->Flash->success(__('Your password has been recovered. You can login right now!'));

                return $this->redirect(['action' => 'login']);
            }
        }
        $this->set(compact('user'));
    }

    /**
     * Register account
     * $token hash from $user->email . $user->token_created . $user->id
     * @return Cake\Network\Response
     */
    public function register()
    {
        if (!Setting::readOrFail('Member.AnyoneCanRegister')) {
            throw new ForbiddenException(__('Register function was disabled. Please contact to your administrator.'));
        }
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            if ($this->Recaptcha->verify()) {
                $role = $this->Users->Roles->findByAlias('member')->first();
                if (!$role) {
                    throw new RecordNotFoundException(__('Default role for register account not found. Please contact to your administrator immediately'));
                }
                $user->role_id = $role->id;
                $user->status = false;
                $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'Register']);
                if ($this->Users->save($user)) {
                    $tokenData = $this->Users->createToken($user->email, $user->status, Setting::readOrFail('Member.RegisterTokenExpired'));
                    $url = Router::url([
                            'prefix' => 'admin',
                            'controller' => 'Users',
                            'action' => 'activeAccount',
                            $tokenData['token'],
                            $user->email,
                            '_full' => true,
                        ]);
                    TableRegistry::get('EmailQueue')
                        ->enqueue($user->email, [
                            'user' => $user,
                            'expired' => $tokenData['expired']->i18nFormat(),
                            'url' => $url
                        ], [
                            'subject' => __('Create account'),
                            'template' => 'Users/register',
                            'format' => 'html',
                            'layout' => 'default'
                        ]);
                    $this->Flash->success(__('Please check your email to verify account.'));

                    return $this->redirect(['action' => 'login']);
                }
            } else {
                $this->Flash->error(__('Please pass Google Recaptcha first'));
            }
        }
        $this->set(compact('user'));
    }

    /**
     * Active Account
     * @param string $token hash from $user->email . $user->token_created . $user->id
     * @param string $email email
     * @return Cake\Network\Response
     */
    public function activeAccount($token = null, $email = null)
    {
        if (!$token || !$email) {
            throw new NotFoundException(__('Missing required information. Please read email carefully and try again.'));
        }
        $user = $this->Users->findByEmailAndStatus($email, false)->first();
        if (!$user) {
            throw new RecordNotFoundException(__('Account not found or already activated. Please read email carefully and try again.'));
        }
        if ($token != Security::hash($user->email . $user->token_created . $user->id, 'sha1', true)) {
            throw new ForbiddenException(__('Invalid token. Please read email carefully and try again.'));
        }
        if (!$user->token_created->wasWithinLast(Setting::readOrFail('Member.RegisterTokenExpired'))) {
            throw new ForbiddenException(__('Your request has been expired. Please contact to your administrator.'));
        }
        unset($user->password);
        if ($this->request->is('put')) {
            $allowedToChange = ['password', 're_password', 'full_name'];
            $data = array_intersect_key($this->request->data, array_flip($allowedToChange));
            $user = $this->Users->patchEntity($user, $data, ['validate' => 'ActiveAccount']);
            $user->status = true;
            if ($this->Users->save($user)) {
                unset($user->password);
                $url = Router::url([
                        'prefix' => 'admin',
                        'controller' => 'Users',
                        'action' => 'login',
                        '_full' => true,
                    ]);
                TableRegistry::get('EmailQueue')
                    ->enqueue($user->email, [
                        'user' => $user,
                        'url' => $url,
                        ], [
                            'subject' => __('Your account has been activated'),
                            'template' => 'Users/account_verified',
                            'layout' => 'default',
                            'format' => 'html'
                        ]);
                $this->Flash->success(__('Your account has been activated. You can login right now'));

                return $this->redirect(['action' => 'login']);
            }
        }
        $this->set(compact('user'));
    }
}
