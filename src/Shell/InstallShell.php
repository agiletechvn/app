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

        $this->out('Creating setting');
        $this->dispatchShell('settings');
        $this->out('<info>Application installed successfully</info>');
        $this->hr();

        $this->donate();
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

    /**
     * donate
     *
     * @return void
     */
    protected function donate()
    {
        $this->out('<info>One more thing...</info>');
        $this->hr();
        $this->out('I hope you enjoy CakePHP. Beside that, you can support me at bellow link');
        $this->hr();
        $this->out('<warning><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=anhtuank7c%40hotmail%2ecom&lc=US&item_name=Crabstudio%20CakePHP%203%20%2d%20FlatAdmin%20Skeleton&item_number=crabstudio%2dcakephp%2dskeleton&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest">Donate</a></warning>');
        $this->hr();
        $this->out('<info>Thank you so much!</info>');
    }
}
