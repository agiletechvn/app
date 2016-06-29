<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\FrozenTime;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Security;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\HasMany $Posts
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('full_name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'existing'
                ]
            ]
        ]);
        $this->addBehavior('Search.Search');
        $this->searchManager()
            ->add('id', 'Search.Value', [
                'field' => $this->aliasField('id')
            ])
            ->add('role_id', 'Search.Value')
            ->add('status', 'Search.Value')
            ->add('email', 'Search.Like', [
                'before' => true,
                'after' => true,
                'field' => [$this->aliasField('email')]
            ])
            ->add('full_name', 'Search.Like', [
                'before' => true,
                'after' => true,
                'field' => [$this->aliasField('full_name')]
            ])
            ->add('created', 'Search.Callback', [
                'callback' => function ($query, $args, $manager) {
                    return $query->andWhere(["DATE(created) >=" => $args['created']]);
                }
            ])
            ->add('modified', 'Search.Callback', [
                'callback' => function ($query, $args, $manager) {
                    return $query->andWhere(["DATE(modified) <=" => $args['modified']]);
                }
            ]);

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'notBlank', [
                'rule' => 'notBlank',
                'message' => __('Email cannot be blank')])
            ->add('email', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => __('Email already in use. Please choose another one')]);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', __('New Password cannot be empty'))
            ->add('password', 'minLength', [
                'rule' => ['minLength', 4],
                'message' => __('Passwords must equal or greater than 4 characters')]);

        $validator
            ->requirePresence('re_password', 'create')
            ->notEmpty('re_password', __('re_password cannot be empty'))
            ->add('re_password', 'minLength', [
                'rule' => ['minLength', 4],
                'message' => __('re_password must equal or greater than 4 characters')])
            ->add('re_password', 'compare', [
                'rule' => ['compareWith', 'password'],
                'message' => __('re_password does not match')]);

        $validator
            ->requirePresence('full_name', 'create')
            ->notEmpty('full_name')
            ->add('full_name', ['notBlank' => [
                'rule' => 'notBlank',
                'message' => __('full name cannot be blank')]]);

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        return $rules;
    }

    /**
     * Register validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationRegister(Validator $validator)
    {
        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'notBlank', [
                'rule' => 'notBlank',
                'message' => __('Email cannot be blank')])
            ->add('email', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => __('Email already in use. Please choose another one')
            ]);

        return $validator;
    }

    /**
     * Reset Password validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationResetPassword(Validator $validator)
    {
        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', __('New Password cannot be blank'))
            ->add('password', 'minLength', [
                'rule' => ['minLength', 4],
                'message' => __('Passwords must equal or greater than 4 characters')]);

        $validator
            ->requirePresence('re_password', 'create')
            ->notEmpty('re_password', __('re_password cannot be blank'))
            ->add('re_password', 'minLength', [
                'rule' => ['minLength', 4],
                'message' => __('re_password must equal or greater than 4 characters'), ])
            ->add('re_password', 'compare', [
                'rule' => ['compareWith', 'password'],
                'message' => __('re_password does not match'), ]);

        return $validator;
    }

    /**
     * Active Account validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationActiveAccount(Validator $validator)
    {
        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', __('New Password cannot be empty'))
            ->add('password', 'minLength', [
                'rule' => ['minLength', 4],
                'message' => __('Passwords must equal or greater than 4 characters')]);
        $validator
            ->requirePresence('re_password', 'create')
            ->notEmpty('re_password', __('re_password cannot be empty'))
            ->add('re_password', 'minLength', [
                'rule' => ['minLength', 4],
                'message' => __('re_password must equal or greater than 4 characters'), ])
            ->add('re_password', 'compare', [
                'rule' => ['compareWith', 'password'],
                'message' => __('re_password does not match'), ]);
        $validator
            ->requirePresence('full_name', 'create')
            ->notEmpty('full_name')
            ->add('full_name', ['notBlank' => [
                'rule' => 'notBlank',
                'message' => __('full name cannot be blank')]]);

        return $validator;
    }

    /**
     * Create token
     * @param string $email email
     * @param bool $status status
     * @param string $expired expired
     * @return array ['token', 'expired']
     */
    public function createToken($email, $status, $expired)
    {
        $user = $this->findByEmailAndStatus($email, $status)->first();
        if (!$user) {
            return false;
        }
        $user->token_created = new FrozenTime('now');
        if ($this->save($user)) {
            return [
                'token' => Security::hash($user->email . $user->token_created . $user->id, 'sha1', true),
                'expired' => $user->token_created->modify("+ $expired"),
                'user' => $user];
        }
        return false;
    }

    /**
     * Edit Password validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationEditPassword(Validator $validator)
    {
        $validator
            ->requirePresence('current_password', 'create')
            ->notEmpty('current_password', __('Current Password cannot be empty'))
            ->add('current_password', 'custom', [
                'rule' => function ($value, $context) {
                    $user = $this->get($context['data']['id'], ['conditions' => ['status' => true]]);
                    if (!$user) {
                        return false;
                    }
                    return (new DefaultPasswordHasher)->check($value, $user->password);
                },
                'message' => __('Current password does not match')
            ]);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', __('password cannot be empty'))
            ->add('password', 'minLength', [
                'rule' => ['minLength', 4],
                'message' => __('password must equal or greater than 4 characters')]);

        $validator
            ->requirePresence('re_password', 'create')
            ->notEmpty('re_password', __('re_password cannot be blank'))
            ->add('re_password', 'minLength', [
                'rule' => ['minLength', 4],
                'message' => __('re_password must equal or greater than 4 characters')])
            ->add('re_password', 'compare', [
                'rule' => ['compareWith', 'password'],
                'message' => __('re_password does not match')
            ]);

        return $validator;
    }

    /**
     * Edit Profile validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationEditProfile(Validator $validator)
    {
        $validator
            ->requirePresence('full_name', 'create')
            ->notEmpty('full_name')
            ->add('full_name', 'notBlank', [
                'rule' => 'notBlank',
                'message' => __('Full name cannot be blank')]);

        return $validator;
    }

    /**
     * deactive account
     *
     * @param int $userId userId
     * @return bool true|false
     */
    public function deactive($userId)
    {
        $user = $this->get($userId);
        $user->status = false;
        return $this->save($user);
    }
}
