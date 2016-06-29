<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Core\Setting;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Hash;

/**
 * Setting Controller
 *
 * @property \App\Model\Table\ConfigurationsTable $Configurations
 */
class SettingController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Tabs');
        $this->loadModel('Configurations');
        Configure::write('Settings.Prefixes.Recaptcha', 'Recaptcha');
        Configure::write('Settings.Prefixes.Meta', 'Meta');
        Configure::write('Settings.Prefixes.Member', 'Member');
        Configure::write('Settings.Prefixes.Maintenance', 'Maintenance');
        Configure::write('Settings.Prefixes.SchedulerShell', 'SchedulerShell');

        Setting::register('Member.AnyoneCanRegister', false, [
            'type' => 'checkbox',
            'weight' => 1,
        ]);
        Setting::register('Member.RegisterTokenExpired', '24 hours', [
            'options' => [
                '24 hours' => '24 hours',
                '36 hours' => '36 hours',
                '72 hours' => '72 hours',
            ],
            'type' => 'select',
            'weight' => 2
        ]);
        Setting::register('Member.ResetPasswordTokenExpired', '24 hours', [
            'options' => [
                '24 hours' => '24 hours',
                '36 hours' => '36 hours',
                '72 hours' => '72 hours',
            ],
            'type' => 'select',
            'weight' => 3
        ]);
        Setting::register('Recaptcha.type', 'image', [
            'options' => [
                'image' => 'image',
                'audio' => 'audio',
            ],
            'type' => 'select',
            'weight' => 1
        ]);
        Setting::register('Recaptcha.theme', 'light', [
            'options' => [
                'light' => 'light',
                'dark' => 'dark',
            ],
            'type' => 'select',
            'weight' => 2
        ]);
        Setting::register('Recaptcha.lang', 'en', [
            'options' => [
                'en' => 'English',
                'ja' => 'Japanese',
                'vi' => 'Vietnamese',
            ],
            'type' => 'select',
            'weight' => 3
        ]);
        Setting::register('Recaptcha.enable', false, ['type' => 'checkbox', 'weight' => 4]);
        Setting::register('Recaptcha.sitekey', '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI', ['type' => 'text', 'weight' => 5]);
        Setting::register('Recaptcha.secret', '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe', ['type' => 'text', 'weight' => 6]);

        Setting::register('Meta.title', 'SBD', ['type' => 'text', 'weight' => 1]);
        Setting::register('Meta.description', 'A completed simple admin backend [roles, users, login, logout, register, forgot password etc...]', [
                'type' => 'textarea',
                'weight' => 2
            ]);
        Setting::register('Meta.logo', '/img/logo.png', ['type' => 'file', 'weight' => 3]);
        Setting::register('Meta.copyright', '<b>SBD</b> all right reserved', ['type' => 'text', 'weight' => 4]);

        Setting::register('SchedulerShell.jobs.01.task', 'EmailSender', [
            'options' => [
                'EmailSender' => 'EmailSender'
            ],
            'description' => 'EmailSender',
            'type' => 'select',
            'weight' => 1
        ]);
        Setting::register('SchedulerShell.jobs.01.interval', 'PT1M', [
            'options' => [
                'PT1M' => __('Each 1 minute'),
                'PT5M' => __('Each 5 minute'),
                'PT1H' => __('Each 1 hour'),
                'PT1D' => __('Each 1 day'),
                'PT1W' => __('Each 1 week'),
                'PT1Y' => __('Each 1 year'),
                'next day 06:00' => __('Next day 06:00am'),
                'weekday 06:00' => __('Monday-Friday at 06:00'),
            ],
            'description' => 'EmailSender',
            'type' => 'select',
            'weight' => 2
        ]);

        $this->prefixes = Configure::read('Settings.Prefixes');
        foreach ($this->prefixes as $prefix => $alias) {
            $this->Tabs->add($alias, [
                'url' => [
                    'action' => 'index', $prefix
                ]
            ]);
        }
    }

    /**
     * Index method
     *
     * @param string $key key
     * @return \Cake\Network\Response|null
     */
    public function index($key = null)
    {
        if (!$key) {
            return $this->redirect(['action' => 'index', 'App']);
        }
        if (!$this->prefixExists($key)) {
            throw new NotFoundException("The prefix-setting $key could not be found");
        }
        $prefix = Hash::get($this->prefixes, ucfirst($key));
        $settings = $this->Configurations->find('all')->where([
            'name LIKE' => $key . '%',
            'editable' => 1,
        ])->order(['weight', 'id']);
        if ($this->request->is(['patch', 'put', 'post'])) {
            $settings = $this->Configurations->patchEntities($settings, $this->request->data);
            foreach ($settings as $setting) {
                if ($this->Configurations->save($setting)) {
                    $this->Flash->success(__('The setting has been saved'));
                } else {
                    $this->Flash->error(__('The setting could not be saved. Please try again.'));
                }
            }
            Setting::clear(true);
            Setting::autoload();
            return $this->redirect([]);
        }
        $this->set(compact('settings', 'prefix'));
        $this->set('_serialize', ['settings']);
    }

    /**
     * prefixExists method
     *
     * @param string|null $prefix prefix
     * @return \Cake\Network\Response|null
     */
    protected function prefixExists($prefix = null)
    {
        if (!$prefix) {
            return false;
        }
        return Hash::get($this->prefixes, ucfirst($prefix)) !== null;
    }
}
