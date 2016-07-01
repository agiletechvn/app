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
        $this->out("\r\nCreate settings");
        $this->loadModel('Configurations');
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
                'value' => 'Anhtuank7c',
                'description' => null,
                'type' => 'text',
                'editable' => 1,
                'weight' => 2,
                'autoload' => 1,
            ],
            [
                'name' => 'App.Logo',
                'value' => '/img/logo.png',
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
                'name' => 'Member.RegisterTokenExpired',
                'value' => '24 hours',
                'description' => null,
                'type' => 'select',
                'editable' => 1,
                'weight' => 2,
                'autoload' => 1,
            ],
            [
                'name' => 'Member.ResetPasswordTokenExpired',
                'value' => '24 hours',
                'description' => null,
                'type' => 'select',
                'editable' => 1,
                'weight' => 3,
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
        ]);
        foreach ($entities as $entity) {
            if ($this->Configurations->save($entity)) {
                $this->out("{$entity->name} has been saved");
            } else {
                $this->out("{$entity->name} could not be saved");
            }
        }
    }
}
