<?php
namespace App\Core;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use RuntimeException;

class Setting
{
    /**
     * List of loaded data
     *
     * @var array
     */
    protected static $_data = [];

    /**
     * Options
     *
     * @var array
     */
    protected static $_options = [];

    /**
     * Holder for the model
     *
     * @var \Cake\ORM\Table
     */
    protected static $_model = null;

    /**
     * Keeps the boolean if the autoload method has been loaded
     *
     * @var bool
     */
    protected static $_autoloaded = false;

    /**
     * read
     *
     * Method to read the data.
     *
     * @param string $key Key with the name of the setting.
     * @return mixed|bool
     */
    public static function read($key = null)
    {
        if (!self::_tableExists()) {
            return false;
        }
        self::autoLoad();
        if (!$key) {
            return self::$_data;
        }
        if ($value = Hash::get(self::$_data, $key)) {
            return $value;
        }
        $model = self::model();
        $data = $model->findByName($key)->select('value');
        if ($data->count() > 0) {
            $data = $data->first()->toArray();
        } else {
            return false;
        }
        self::_store($key, $data['value']);

        return $value;
    }

    /**
     * read
     *
     * Method to read the data.
     *
     * @param string $key Key with the name of the setting.
     * @param string $type The type to return in.
     * @return mixed|bool
     * @throws RuntimeException
     */
    public static function readOrFail($key = null, $type = null)
    {
        if (!self::check($key, $type)) {
            throw new RuntimeException(sprintf('Expected configuration key "%s" not found.', $key));
        }

        return self::read($key, $type);
    }

    /**
     * write
     *
     * Method to write data to database.
     *
     * ### Example
     *
     * Setting::write('Plugin.Autoload', true);
     *
     * ### Options
     *  - editable  value if the setting is editable in the admin-area. Default 1 (so, editable)
     *  - overrule  boolean if the setting should be written if it already exists. Default true.
     *
     * Example:
     * Setting::write('Plugin.Autoload', false, [
     *      'overrule' => true,
     *      'editable' => 0,
     * ]
     *
     * @param string $key Key of the value. Must contain an prefix.
     * @param mixed $value The value of the key.
     * @param array $options Options array.
     * @return void|bool
     */
    public static function write($key, $value = null, $options = [])
    {
        if (!self::_tableExists()) {
            return false;
        }
        self::autoLoad();
        $_options = [
            'editable' => 1,
            'overrule' => true,
        ];
        $options = Hash::merge($_options, $options);
        $model = self::model();
        if (self::check($key)) {
            if (!$options['overrule']) {
                return false;
            }
            $data = $model->findByName($key)->first();
            if (!$data) {
                return false;
            }
            $data->set('value', $value);
            if (!$model->save($data)) {
                return false;
            }
        } else {
            $data = $model->newEntity($options);
            $data->name = $key;
            $data->value = $value;
            if (!$model->save($data)) {
                return false;
            }
        }
        self::_store($key, $value);

        return true;
    }

    /**
     * check
     *
     * Checks if an specific key exists.
     * Returns boolean.
     *
     * @param string $key Key.
     * @return bool|void
     */
    public static function check($key)
    {
        if (empty($key)) {
            return false;
        }
        self::autoLoad();
        if (Hash::get(self::$_data, $key)) {
            return true;
        }
        if (!self::_tableExists()) {
            return false;
        }
        $model = self::model();
        $query = $model->findByName($key);
        if (!$query->Count()) {
            return false;
        }

        return true;
    }

    /**
     * model
     *
     * Returns an instance of the Configurations-model (Table).
     * Also used as setter for the instance of the model.
     *
     * @param \Cake\ORM\Table|null $model Model to use.
     * @return \Cake\ORM\Table
     */
    public static function model($model = null)
    {
        if ($model) {
            self::$_model = $model;
        }
        if (!self::$_model) {
            self::$_model = TableRegistry::get('Configurations');
        }

        return self::$_model;
    }

    /**
     * register
     *
     * Registers a setting and its default values.
     *
     * @param string $key The key.
     * @param mixed $value The default value.
     * @param array $data Custom data.
     * @return void
     */
    public static function register($key, $value, $data = [])
    {
        if (!self::_tableExists()) {
            return;
        }
        self::autoLoad();
        $_data = [
            'value' => $value,
            'editable' => 1,
            'autoload' => true,
            'options' => [],
            'description' => null,
        ];
        $data = array_merge($_data, $data);
        // Don't overrule because we register
        $data['overrule'] = false;
        self::options($key, $data['options']);
        self::write($key, $data['value'], $data);
    }

    /**
     * options
     *
     * @param string $key Key for options.
     * @param array $value Options to use.
     * @return mixed
     */
    public static function options($key, $value = null)
    {
        if (!self::_tableExists()) {
            return false;
        }
        if ($value) {
            self::$_options[$key] = $value;
        }
        if (array_key_exists($key, self::$_options)) {
            return self::$_options[$key];
        } else {
            return false;
        }
    }

    /**
     * autoLoad
     *
     * AutoLoad method.
     * Loads all configurations who are autoloaded.
     *
     * @return void
     */
    public static function autoLoad()
    {
        if (!self::_tableExists()) {
            return;
        }
        if (self::$_autoloaded) {
            return;
        }
        self::$_autoloaded = true;
        $model = self::model();
        $query = $model->find('all')->where(['autoload' => 1])->select(['name', 'value'])->hydrate(false)->toArray();
        foreach ($query as $k => $v) {
            self::_store($v['name'], $v['value']);
        }
    }

    /**
     * clear
     *
     * Clears all settings out of the class. Settings
     * won't be deleted from database.
     *
     * @param bool $reload Bool if settings should be reloaded
     * @return void
     */
    public static function clear($reload = false)
    {
        self::$_autoloaded = !$reload;
        self::$_data = [];
    }

    /**
     * Used to cache delete a key from Setting.
     *
     * Usage:
     * ```
     * Setting::delete('Name'); will delete the entire Setting::Name
     * Setting::delete('Name.key'); will delete only the Setting::Name[key]
     * ```
     *
     * @param string $key the key to be deleted
     * @return void
     */
    public static function delete($key)
    {
        self::$_data = Hash::remove(self::$_data, $key);
    }

    /**
     * _store
     *
     * Stores recent data in the $_data-variable.
     *
     * @param string $key The key.
     * @param mixed $value The value.
     * @return void
     */
    protected static function _store($key, $value = null)
    {
        if (!is_array($key)) {
            $key = [$key => $value];
        }
        foreach ($key as $name => $value) {
            self::$_data = Hash::insert(self::$_data, $name, $value);
        }
    }

    /**
     * _tableExists
     *
     * @return bool
     */
    protected static function _tableExists()
    {
        $db = ConnectionManager::get('default');
        $tables = $db->schemaCollection()->listTables();

        return in_array('configurations', $tables);
    }
}
