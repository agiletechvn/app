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

        Configure::write('Settings.Prefixes.App', 'App');
        Configure::write('Settings.Prefixes.Recaptcha', 'Recaptcha');
        Configure::write('Settings.Prefixes.Member', 'Member');
        Configure::write('Settings.Prefixes.Maintenance', 'Maintenance');
        Configure::write('Settings.Prefixes.SchedulerShell', 'SchedulerShell');
        Configure::write('Settings.Prefixes.Remember', 'Remember');
        Configure::write('Settings.Prefixes.BruteForceProtection', 'BruteForceProtection');

        Setting::register('App.Name', 'CakePHP', ['type' => 'text', 'weight' => 1]);
        Setting::register('App.Logo', '/uploads/logo.png', ['type' => 'file', 'weight' => 2]);
        Setting::register('App.Copyright', '<b>SBD</b> all right reserved', ['type' => 'text', 'weight' => 3]);
        Setting::register('App.Debug', true, ['type' => 'checkbox', 'weight' => 4]);

        Setting::register('Member.AnyoneCanRegister', false, ['type' => 'checkbox', 'weight' => 1]);
        Setting::register('Member.AnyoneCanDeactive', false, ['type' => 'checkbox', 'weight' => 2]);
        Setting::register('Member.RegisterTokenExpired', '24 hours', [
            'options' => [
                '24 hours' => '24 hours',
                '36 hours' => '36 hours',
                '72 hours' => '72 hours',
            ],
            'type' => 'select',
            'weight' => 3
        ]);
        Setting::register('Member.ResetPasswordTokenExpired', '24 hours', [
            'options' => [
                '24 hours' => '24 hours',
                '36 hours' => '36 hours',
                '72 hours' => '72 hours',
            ],
            'type' => 'select',
            'weight' => 4
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
                'de' => 'German',
                'fr' => 'French',
                'th' => 'Thai',
                'es' => 'Spanish',
                'lo' => 'Laothian',
                'ms' => 'Malay',
                'id' => 'Indonesian',
                'cs' => 'Czech',
                'zh-CN' => 'Chinese (Simplified)',
            ],
            'type' => 'select',
            'weight' => 3
        ]);
        Setting::register('Recaptcha.enable', false, ['type' => 'checkbox', 'weight' => 4]);
        Setting::register('Recaptcha.sitekey', '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI', ['type' => 'text', 'weight' => 5]);
        Setting::register('Recaptcha.secret', '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe', ['type' => 'text', 'weight' => 6]);

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
                'P1D' => __('Each 1 day'),
                'P3D' => __('Each 3 day'),
                'P1W' => __('Each 1 week'),
                'P2W' => __('Each 2 week'),
                'P1M' => __('Each 1 month'),
                'P2M' => __('Each 2 month'),
                'P1Y' => __('Each 1 year'),
                'next day 06:00' => __('Next day 06:00am'),
                'weekday 06:00' => __('Monday-Friday at 06:00'),
            ],
            'description' => 'EmailSender',
            'type' => 'select',
            'weight' => 2
        ]);

        Setting::register('SchedulerShell.jobs.02.task', 'Backup', [
            'options' => [
                'Backup' => 'Backup'
            ],
            'description' => 'Backup',
            'type' => 'select',
            'weight' => 3
        ]);
        Setting::register('SchedulerShell.jobs.02.interval', 'PT1W', [
            'options' => [
                'PT1M' => __('Each 1 minute'),
                'PT5M' => __('Each 5 minute'),
                'PT1H' => __('Each 1 hour'),
                'P1D' => __('Each 1 day'),
                'P3D' => __('Each 3 day'),
                'P1W' => __('Each 1 week'),
                'P2W' => __('Each 2 week'),
                'P1M' => __('Each 1 month'),
                'P2M' => __('Each 2 month'),
                'P1Y' => __('Each 1 year'),
                'next day 06:00' => __('Next day 06:00am'),
                'weekday 06:00' => __('Monday-Friday at 06:00'),
            ],
            'description' => 'Backup',
            'type' => 'select',
            'weight' => 4
        ]);

        Setting::register('Maintenance.enable', false, ['type' => 'checkbox', 'weight' => 1]);
        Setting::register('Maintenance.allowedIp', '127.0.0.1', ['type' => 'text', 'weight' => 2]);

        //Brute Force Protection
        Setting::register('BruteForceProtection.retries', 3, ['type' => 'number', 'description' => 'Number of allowed login attempts', 'weight' => 1, 'min' => 3, 'max' => 10]);
        Setting::register('BruteForceProtection.expires', '5 minutes', [
            'options' => [
                '5 minutes' => __('5 minutes'),
                '10 minutes' => __('10 minutes'),
                '15 minutes' => __('15 minutes'),
                '1 day' => __('1 day'),
                '3 days' => __('3 days'),
            ],
            'description' => 'Time to block attack ip',
            'type' => 'select',
            'weight' => 2,
        ]);
        Setting::register('BruteForceProtection.file_path', 'prevent_brute_force', ['type' => 'text', 'description' => 'Folder to store list attacker ip', 'weight' => 3]);
        Setting::register('BruteForceProtection.message.locked', 'You have exceeded the number of allowed login attempts. Please try again in {0}', ['type' => 'text', 'description' => 'Locked message', 'weight' => 4]);
        Setting::register('BruteForceProtection.message.login_fail', 'Incorrect username or password. {0} retries remain. Please try again', ['type' => 'text', 'description' => 'Retries remain message', 'weight' => 5]);

        // Remember
        Setting::register('Remember.enable', true, ['type' => 'checkbox', 'description' => 'Allow store user/pass to Cookie', 'weight' => 1]);
        Setting::register('Remember.key', 'RememberMe', ['type' => 'text', 'description' => 'Key to store', 'weight' => 2]);
        Setting::register('Remember.expires', '1 month', [
            'options' => [
                '1 week' => __('1 week'),
                '1 month' => __('1 month'),
                '3 months' => __('3 months'),
                '6 months' => __('6 months'),
            ],
            'description' => 'Time to keep in Cookie',
            'type' => 'select',
            'weight' => 3
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
