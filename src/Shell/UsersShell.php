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
        $this->out("\r\nCreate a new administrator");
        $this->loadModel('Roles');
        $roleAdmin = $this->Roles->find()->where(['alias' => 'admin'])->first();
        if (!$roleAdmin) {
            $this->out("\r\nRole admin does not exist");
            $this->hr();

            return false;
        }
        $this->loadModel('Users');
        $user = $this->Users->newEntity();

        enterInputs: {
            $email = $this->in('E-mail address:');
            $password = $this->in('Password: [ENCRYPT]');
            $rePassword = $this->in('RePassword:');
            $fullName = $this->in('Full name:');
            $status = $this->in('status', ['y', 'n'], 'y');

            $data = [
                'email' => $email,
                'password' => $password,
                're_password' => $rePassword,
                'full_name' => $fullName,
                'status' => (strtolower($status) === 'y')?true:false,
                'role_id' => $roleAdmin->id
            ];
            $user = $this->Users->patchEntity($user, $data);
            }

            if (!empty($user->errors())) {
                $this->out("\r\nOops! Something went wrong.");
                foreach ($user->errors() as $k => $v) {
                    foreach ($v as $field => $error) {
                        $this->out($k . ': ' . $error);
                    }
                }
                $this->out("Please try again");
                goto enterInputs;
            }
            $this->Users->save($user);
            $this->out("Users \"{$user->full_name}\" has been saved");

            return true;
    }
}
