<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;

/**
 * Backup shell task.
 */
class BackupTask extends Shell
{

    /**
     * main() method.
     *
     * @return void
     */
    public function main()
    {
        $this->out('Backing up database');
        $this->database();
        $this->out('Database has been backed up');
    }

    /**
     * dump existing database to the file
     *
     * @return void
     */
    protected function database()
    {
        $conn = ConnectionManager::get('default');
        $tables = $conn->schemaCollection()->listTables();
        foreach ($tables as $k => $v) {
            $this->out("Exporting table $v");
            $sql = <<<EOL
DROP TABLE $v;
CREATE TABLE $v;
EOL;
            $fields = $conn->execute("SHOW COLUMN FROM $v")->fetchAll('assoc');
            $tableData = $conn->execute("SELECT * FROM $v")->fetchAll('assoc');
            $sql .= "INSERT INTO $v ({implode(', ', $fields)}) VALUES (";
            foreach ($tableData as $data) {
                $sql .= "({implode(', ', $data)})";
            }
            $sql .= ";";
            $this->out("<info>Table $v has beend exported</info>");
        }
        $backup = new Folder(TMP . 'backup');
        $fileName = time() '.sql.gz';
        file_put_contents('compress.zlib://' . TMP . 'backup' . DS . $fileName, $sql);
        $this->out("Generated $fileName in folder project/tmp/backup/");
    }
}
