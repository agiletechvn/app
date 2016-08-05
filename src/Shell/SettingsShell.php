<?php
namespace App\Shell;

use Cake\Console\Shell;

/**
 * Settings shell command.
 */
class SettingsShell extends Shell
{
    /**
     * main() method.
     *
     * @return void
     */
    public function main()
    {
        $this->loadModel('Configurations');
        $settings = $this->Configurations->find('all');
        if ($settings->count() > 0) {
            $this->out("\r\nWipe existing settings");
            $this->Configurations->connection()->execute('truncate table configurations');
        }
        $entities = $this->Configurations->newEntities([
            [
                'name' => 'App.Name',
                'value' => 'CakePHP',
                'description' => null,
                'type' => 'text',
                'editable' => 1,
                'weight' => 1,
                'autoload' => 1,
            ],
            [
                'name' => 'App.Copyright',
                'value' => 'Your copyright',
                'description' => null,
                'type' => 'text',
                'editable' => 1,
                'weight' => 2,
                'autoload' => 1,
            ],
            [
                'name' => 'App.Logo',
                'value' => '/uploads/logo.png',
                'description' => null,
                'type' => 'file',
                'editable' => 1,
                'weight' => 3,
                'autoload' => 1,
            ],
            [
                'name' => 'App.Debug',
                'value' => 1,
                'description' => null,
                'type' => 'checkbox',
                'editable' => 1,
                'weight' => 4,
                'autoload' => 1,
            ],
            [
                'name' => 'Recaptcha.type',
                'value' => 'image',
                'description' => null,
                'type' => 'select',
                'editable' => 1,
                'weight' => 1,
                'autoload' => 1,
            ],
            [
                'name' => 'Recaptcha.theme',
                'value' => 'light',
                'description' => null,
                'type' => 'select',
                'editable' => 1,
                'weight' => 2,
                'autoload' => 1,
            ],
            [
                'name' => 'Recaptcha.lang',
                'value' => 'en',
                'description' => null,
                'type' => 'select',
                'editable' => 1,
                'weight' => 3,
                'autoload' => 1,
            ],
            [
                'name' => 'Recaptcha.enable',
                'value' => 1,
                'description' => null,
                'type' => 'checkbox',
                'editable' => 1,
                'weight' => 4,
                'autoload' => 1,
            ],
            [
                'name' => 'Recaptcha.sitekey',
                'value' => '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI',
                'description' => null,
                'type' => 'text',
                'editable' => 1,
                'weight' => 5,
                'autoload' => 1,
            ],
            [
                'name' => 'Recaptcha.secret',
                'value' => '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe',
                'description' => null,
                'type' => 'text',
                'editable' => 1,
                'weight' => 6,
                'autoload' => 1,
            ],
            [
                'name' => 'SchedulerShell.jobs.01.task',
                'value' => 'EmailSender',
                'description' => 'EmailSender',
                'type' => 'text',
                'editable' => 0,
                'weight' => 1,
                'autoload' => 1,
            ],
            [
                'name' => 'SchedulerShell.jobs.01.interval',
                'value' => 'PT1M',
                'description' => 'EmailSender',
                'type' => 'select',
                'editable' => 1,
                'weight' => 2,
                'autoload' => 1,
            ],
            [
                'name' => 'SchedulerShell.jobs.02.task',
                'value' => 'Backup',
                'description' => 'Backup',
                'type' => 'text',
                'editable' => 0,
                'weight' => 3,
                'autoload' => 1,
            ],
            [
                'name' => 'SchedulerShell.jobs.02.interval',
                'value' => 'P1M',
                'description' => 'Backup',
                'type' => 'select',
                'editable' => 1,
                'weight' => 4,
                'autoload' => 1,
            ],
            [
                'name' => 'Member.AnyoneCanRegister',
                'value' => 1,
                'description' => null,
                'type' => 'checkbox',
                'editable' => 1,
                'weight' => 1,
                'autoload' => 1,
            ],
            [
                'name' => 'Member.AnyoneCanDeactive',
                'value' => 1,
                'description' => null,
                'type' => 'checkbox',
                'editable' => 1,
                'weight' => 2,
                'autoload' => 1,
            ],
            [
                'name' => 'Member.RegisterTokenExpired',
                'value' => '24 hours',
                'description' => null,
                'type' => 'select',
                'editable' => 1,
                'weight' => 3,
                'autoload' => 1,
            ],
            [
                'name' => 'Member.ResetPasswordTokenExpired',
                'value' => '24 hours',
                'description' => null,
                'type' => 'select',
                'editable' => 1,
                'weight' => 4,
                'autoload' => 1,
            ],
            [
                'name' => 'Maintenance.enable',
                'value' => 0,
                'description' => null,
                'type' => 'checkbox',
                'editable' => 1,
                'weight' => 1,
                'autoload' => 1,
            ],
            [
                'name' => 'Maintenance.allowedIp',
                'value' => '127.0.0.1',
                'description' => null,
                'type' => 'text',
                'editable' => 1,
                'weight' => 2,
                'autoload' => 1,
            ],

            //BruteForceProtection
            [
                'name' => 'BruteForceProtection.retries',
                'value' => 3,
                'description' => 'Number of allowed login attempts',
                'type' => 'number',
                'editable' => 1,
                'weight' => 1,
                'autoload' => 1,
            ],
            [
                'name' => 'BruteForceProtection.expires',
                'value' => '5 minutes',
                'description' => 'Time to block attack ip',
                'type' => 'select',
                'editable' => 1,
                'weight' => 2,
                'autoload' => 1,
            ],
            [
                'name' => 'BruteForceProtection.file_path',
                'value' => 'prevent_brute_force',
                'description' => 'Folder to store list attacker ip',
                'type' => 'text',
                'editable' => 1,
                'weight' => 3,
                'autoload' => 1,
            ],
            [
                'name' => 'BruteForceProtection.message.locked',
                'value' => 'You have exceeded the number of allowed login attempts. Please try again in {0}',
                'description' => 'Locked message',
                'type' => 'text',
                'editable' => 1,
                'weight' => 4,
                'autoload' => 1,
            ],
            [
                'name' => 'BruteForceProtection.message.login_fail',
                'value' => 'Incorrect username or password. {0} retries remain. Please try again',
                'description' => 'Retries remain message',
                'type' => 'text',
                'editable' => 1,
                'weight' => 5,
                'autoload' => 1,
            ],
            // Remember
            [
                'name' => 'Remember.enable',
                'value' => 1,
                'description' => 'Allow store user/pass to Cookie',
                'type' => 'checkbox',
                'editable' => 1,
                'weight' => 1,
                'autoload' => 1,
            ],
            [
                'name' => 'Remember.key',
                'value' => 'RememberMe',
                'description' => 'Key to store',
                'type' => 'text',
                'editable' => 1,
                'weight' => 2,
                'autoload' => 1,
            ],
            [
                'name' => 'Remember.expires',
                'value' => '1 month',
                'description' => 'Time to keep in Cookie',
                'type' => 'select',
                'editable' => 1,
                'weight' => 3,
                'autoload' => 1,
            ],
        ]);
        $this->out("\r\nCreate settings");
        foreach ($entities as $entity) {
            if ($this->Configurations->save($entity)) {
                $this->out("{$entity->name} has been saved");
            } else {
                $this->out("{$entity->name} could not be saved");
            }
        }
    }
}
