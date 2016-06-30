<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\I18n\FrozenTime;

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
        $this->out("Backing up database\r\n");
        $this->database();
        $this->out('Finish!');
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
        $sql = "";
        //each tables
        $lastTable = end($tables);
        foreach ($tables as $k => $table) {
            $sql .= "DROP TABLE IF EXISTS $table;";
            $sql .= "\r\n\r\nCREATE TABLE $table (";

            //Generate columns
            $fields = $conn->execute("SHOW COLUMNS FROM $table")->fetchAll('assoc');
            $lastColumn = end($fields);
            //each fields
            foreach ($fields as $key => $field) {
                $notNull = $field['Null'] === 'NO'?'NOT NULL':'DEFAULT NULL';
                $default = empty($field['Default'])?'':"DEFAULT '{$field['Default']}'";
                if ($lastColumn !== $field) {
                    $sql .= "\r\n\t{$field['Field']} {$field['Type']} $notNull {$default},";
                } else {
                    $sql .= "\r\n\t{$field['Field']} {$field['Type']} $notNull {$default}";
                }
            }
            $sql .= "\r\n);";

            //Generate values
            $rows = $conn->execute("SELECT * FROM $table")->fetchAll('assoc');

            //each table rows
            $lastRow = end($rows);
            foreach ($rows as $kk => $row) {
                $sql .= "\r\n\r\nINSERT INTO $table (";
                $lastColumn = end($fields);

                //each fields
                foreach ($fields as $key => $field) {
                    if ($lastColumn !== $field) {
                        $sql .= "{$field['Field']}, ";
                    } else {
                        $sql .= "{$field['Field']}";
                    }
                }
                $sql .= ") VALUES (";
                //each fields values
                $fieldCount = count($row);
                $count = 0;
                foreach ($row as $key => $value) {
                    $count++;
                    if (null == $value) {
                        if ($count < $fieldCount) {
                            $sql .= "NULL, ";
                        } else {
                            $sql .= "NULL";
                        }
                    } else {
                        if ($count < $fieldCount) {
                            $sql .= "'$value', ";
                        } else {
                            $sql .= "'$value'";
                        }
                    }
                }
                if ($lastRow !== $row) {
                    $sql .= "),";
                } else {
                    $sql .= ");\r\n\r\n";
                }
            }
            $this->out("exported: $table");
        }

        // INCOMPLETE TABLE KEYS GENERATION
        // foreach ($tables as $k => $table) {
        //     //Generate keys
        //     $keys = $conn->execute("SHOW KEYS FROM $table")->fetchAll('assoc');
        // }

        $backup = new Folder(TMP . 'backup', true);
        $fileName = (new FrozenTime())->i18nFormat("yyyyMMddHHmmss") . '.sql';
        file_put_contents(TMP . 'backup' . DS . $fileName, $sql);
        file_put_contents('compress.zlib://' . TMP . 'backup' . DS . $fileName . '.gz', file_get_contents(TMP . 'backup' . DS . $fileName));
        unlink(TMP . 'backup' . DS . $fileName);
        $this->out("\r\nGenerated backup: " . TMP . "backup" . DS . $fileName . ".gz");
    }
}
