<?php
namespace App\Database\Type;

use Cake\Database\Driver;
use Cake\Database\Type\StringType;

class SerializeType extends StringType
{
    /**
     * toPHP method
     * @param string $value value
     * @param \Cake\Database\Driver $driver driver
     * @return void|string encoded json
     */
    public function toPHP($value, Driver $driver)
    {
        if ($value === null) {
            return;
        }

        return unserialize($value);
    }

    /**
     * toDatabase method
     * @param string $value value
     * @param \Cake\Database\Driver $driver driver
     * @return string encoded json
     */
    public function toDatabase($value, Driver $driver)
    {
        return serialize($value);
    }

    /**
     * marshal method
     * @param string $value value
     * @return string
     */
    public function marshal($value)
    {
        return $value;
    }

    /**
     * requiresToPhpCast method
     * @return bool
     */
    public function requiresToPhpCast()
    {
        return true;
    }
}
