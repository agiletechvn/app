<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Migrations\Migrations;

/**
 * Install shell command.
 */
class InstallShell extends Shell
{
    /**
     * main() method.
     *
     * @return bool
     */
    public function main()
    {
        $this->out("Migrating Tables...");
        $this->migrate();
        if (!$this->tableExists('roles')) {
            $this->out("Migrating could not be done!");

            return false;
        }
        $this->out("Migrating Initial Tables completed!");
        $this->dispatchShell('roles');
        $this->loadModel('Users');
        $createAdmin = $this->in("\r\nDo you want to create your first administrator?", ['y', 'n'], 'y');
        if (strtolower($createAdmin) === 'y') {
            $this->dispatchShell('users');
        } else {
            $this->out("\r\nTo create a new administrator, run: bin/cake users");
        }

        $this->dispatchShell('settings');

        $this->out("\r\n");
        $this->out("Application installed successfully");
        $this->out("\r\n");

        $this->donate();

        return true;
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
     * Checks if the table exists.
     *
     * @param string $table table name
     * @return bool
     */
    protected function tableExists($table)
    {
        $db = ConnectionManager::get('default');
        $tables = $db->schemaCollection()->listTables();

        return in_array($table, $tables);
    }

    /**
     * donate
     *
     * @return void
     */
    protected function donate()
    {
        $data = [
            ['One more thing...'],
            ['I love CakePHP and i try my best to help you enjoy it'],
            ['Support me: bit.ly/29f7FWE'],
            ['Let\'s simplify the world together'],
            ['Email: anhtuank7c@hotmail.com, Github: github.com/crabstudio']
        ];
        $this->helper('Table')->output($data);
    }
}
