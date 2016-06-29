<?php
namespace App\Shell;

use Cake\Console\Shell;

/**
 * Users shell command.
 */
class UsersShell extends Shell
{
    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main()
    {
        $this->loadModel('Roles');
        $roleAdmin = $this->Roles->find()->where(['alias' => 'admin'])->first();
        if (!$roleAdmin) {
            $this->out('<error>Role admin does not exist. Please create admin role first.</error>');
            return false;
        }
        $this->loadModel('Users');
        $user = $this->Users->newEntity();
        do {
            $email = $this->in('E-mail address:');
            $password = $this->in('Password: [ENCRYPT]');
            $rePassword = $this->in('RePassword:');
            $fullName = $this->in('Full name:');
            $status = $this->in('status', ['Y', 'n'], 'Y');

            $user = $this->Users->patchEntity($user, [
                'email' => $email,
                'password' => $password,
                're_password' => $rePassword,
                'full_name' => $fullName,
                'status' => ($status == 'y')?true:false,
                'role' => $roleAdmin
            ]);
        } while (empty($user->errors()));

        if ($this->Users->save($user)) {
            $this->out('<info>Users ' . $user->full_name . ' has been saved<info>');
            return true;
        }
        $this->out('<error>The user ' . $user->full_name . ' could not be saved<error>');
        return false;
    }
}
