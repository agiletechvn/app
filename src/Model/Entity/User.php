<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity.
 *
 * @property int $id
 * @property int $role_id
 * @property \App\Model\Entity\Role $role
 * @property string $email
 * @property string $full_name
 * @property string $password
 * @property bool $status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $token_created
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false, ];

    /**
     * Fields that are excluded from JSON an array versions of the entity.
     *
     * @var array
     */
    protected $_hidden = ['password'];

    /**
     * _setPassword
     * @param string $password password
     * @return string
     */
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher())->hash($password);
    }
}
