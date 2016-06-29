<?php
namespace App\Database\Type;

use Cake\Database\Driver;
use Cake\Database\Type\StringType;

class JsonType extends StringType
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

        return json_decode($value, true);
    }

    /**
     * marshal method
     * @param string $value value
     * @return array|string encoded json
     */
    public function marshal($value)
    {
        if (is_array($value) || $value === null) {
            return $value;
        }

        return json_decode($value, true);
    }

    /**
     * toDatabase method
     * @param string $value value
     * @param \Cake\Database\Driver $driver driver
     * @return string encoded json
     */
    public function toDatabase($value, Driver $driver)
    {
        return json_encode($value);
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
