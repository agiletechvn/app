<?php
namespace App\Model\Entity;

use App\Core\Setting;
use Cake\ORM\Entity;

/**
 * Configuration Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $description
 * @property string $type
 * @property bool $editable
 * @property int $weight
 * @property bool $autoload
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Configuration extends Entity
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
        'id' => false,
    ];

    /**
     * _setKey method
     * @param string $key key
     * @return void
     */
    protected function _setKey($key)
    {
        $this->set('name', $key);
    }

    /**
     * _getKey method
     *
     * @return mix
     */
    protected function _getKey()
    {
        return $this->get('name');
    }

    /**
     * _getOptions method
     *
     * @return mix|bool
     */
    protected function _getOptions()
    {
        if (array_key_exists('name', $this->_properties)) {
            $options = Setting::options($this->_properties['name']);
            if (is_callable($options)) {
                return $options();
            }

            return $options;
        }

        return false;
    }

    protected $_virtual = ['options'];
}
