<?php
namespace App\Shell;

use Cake\Console\Shell;
use Migrations\Migrations;

/**
 * Install shell command.
 */
class InstallShell extends Shell
{
    /**
     * main() method.
     *
     * @return void
     */
    public function main()
    {
        $this->out('Migrating Tables...');
        $this->migrate();
        $this->out('<info>Migrating Initialize Tables completed!</info>');
        $this->hr();

        $this->out('Creating roles...');
        $this->dispatchShell('roles');

        $this->loadModel('Users');
        $createAdmin = $this->in('Do you want to create your first administrator?', ['Y', 'n'], 'Y');
        if ($createAdmin == 'Y') {
            $this->out('Creating a new administrator');
            $this->dispatchShell('users');
            $this->hr();
        }
    }

    /**
     * Migrates
     *
     * @return bool
     */
    protected function migrate()
    {
        $migrations = new Migrations();
        return $migrations->migrate();
    }
}
