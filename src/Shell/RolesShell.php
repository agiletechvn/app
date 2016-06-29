<?php
namespace App\Shell;

use Cake\Console\Shell;

/**
 * Roles shell command.
 */
class RolesShell extends Shell
{
    /**
     * main() method.
     *
     * @return void
     */
    public function main()
    {
        $this->out('Creating roles...');
        $this->loadModel('Roles');
        $entities = $this->Administrators->newEntities([
            [
                'alias' => 'admin',
                'name' => 'Admin',
                'description' => 'Privilege level I'
            ],
            [
                'alias' => 'manager',
                'name' => 'Manager',
                'description' => 'Privilege level II'
            ],
            [
                'alias' => 'member',
                'name' => 'Member',
                'description' => 'Privilege level III'
            ],
        ]);
        foreach ($entities as $entity) {
            if ($this->Roles->save($entity)) {
                $this->out('<info>Role ' . $entity->name . ' has been saved</info>');
                $this->hr();
            } else {
                $this->out('<error>Role ' . $entity->name . ' could not be saved</error>');
                $this->hr();
            }
        }
    }
}
