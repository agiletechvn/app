<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    /**
     * Up function
     * @return void
     */
    public function up()
    {
        $table = $this->table('roles');
        $table
            ->addColumn('alias', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(['alias'], ['unique' => true])
            ->create();

        $table = $this->table('users');
        $table
            ->addColumn('role_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('full_name', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('status', 'boolean', [
                'default' => 0,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('token_created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'email',
                ],
                ['unique' => true]
            )
            ->addIndex(['role_id'])
            ->create();

        $this->table('users')
            ->addForeignKey(
                'role_id',
                'roles',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();
    }

    /**
     * Down function
     * @return void
     */
    public function down()
    {
        $this->table('users')
            ->dropForeignKey(
                'role_id'
            );
        $this->dropTable('roles');
        $this->dropTable('users');
    }
}
