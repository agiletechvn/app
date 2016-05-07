<?php
use Cake\Auth\DefaultPasswordHasher;
use Phinx\Seed\AbstractSeed;

class FlatAdminSeeder extends AbstractSeed
{
    /**
     * Run Method.
     * Insert default value into your database
     * roles:
     * [
     *      admin, manager, member
     * ]
     * users:
     * [
     *      email = admin@example.com,
     *      password = admin@1234,
     * ]
     */
    public function run()
    {
        // Insert roles
        $roleData = [
            [
                'alias' => 'admin',
                'name' => 'Admin',
                'description' => 'Highest privilege. Can do anything in anywhere. All privilege are defined in acl.ini, you can define it yourself',
                'created' => date('Y-m-d H:i:s'),
            ],
            [
                'alias' => 'manager',
                'name' => 'Manager',
                'description' => 'High privilege after Administrator role. All privilege are defined in acl.ini, you can define it yourself',
                'created' => date('Y-m-d H:i:s'),
            ],
            [
                'alias' => 'member',
                'name' => 'Member',
                'description' => 'Minimum privilege All privilege are defined in acl.ini, you can define it yourself',
                'created' => date('Y-m-d H:i:s'),
            ],
        ];
        $Roles = $this->table('roles');
        $Roles->insert($roleData)->save();

        // find admin role id
        $adminRole = $this->fetchRow("SELECT id FROM roles WHERE alias = 'admin'");
        if (!$adminRole) {
            throw new \Exception('admin role does not exist. Please wipe your database then seeding data again');
        }

        // Insert user
        $userData = [
            [
                'role_id' => $adminRole[0],
                'email' => 'admin@example.com',
                'full_name' => 'Administrator',
                'status' => true,
                'password' => (new DefaultPasswordHasher)->hash('admin@1234'),
                'created' => date('Y-m-d H:i:s')
            ]
        ];
        $Users = $this->table('users');
        $Users->insert($userData)->save();
    }
}
