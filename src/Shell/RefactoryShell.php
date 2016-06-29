<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Migrations\Migrations;

/**
 * Refactory shell command.
 */
class RefactoryShell extends Shell
{
    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main()
    {
        $this->out('<info>Refactory database</info>');
        $confirm = $this->in('<warning>Are you sure you want to restore database to factory. (Destroy existing)<warning>', ['Y', 'N'], 'N');
        if ($confirm == 'N') {
            $this->out('<info>You choose No. Nothing changed</info>');
            return false;
        }

        $this->out('Wiping data');
        $this->wipe();
        $this->out('<info>Wiped</info>');

        $this->out('Reinstall database');
        $this->dispatchShell('install');
    }

    /**
     * wipe() method.
     *
     * @return void
     */
    protected function wipe()
    {
        $conn = ConnectionManager::get('default');
        $tables = $conn->schemaCollection()->listTables();

        $this->out('Disable foreign key');
        $disableForeignKeyStmt = $conn->prepare('SET FOREIGN_KEY_CHECKS = 0');
        $disableForeignKeyStmt->execute();

        $this->out('Drop tables');
        $dropTablesStmt = $conn->prepare("DROP TABLE " . implode(', ', $tables));
        $dropTablesStmt->execute();

        $this->out('Enable foreign key');
        $enableForeignKeyStmt = $conn->prepare('SET FOREIGN_KEY_CHECKS = 1');
        $enableForeignKeyStmt->execute();
    }
}
