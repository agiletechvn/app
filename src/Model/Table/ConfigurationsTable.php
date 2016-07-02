<?php
namespace App\Model\Table;

use App\Model\Entity\Configuration;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Configurations Model
 *
 */
class ConfigurationsTable extends Table
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

        $this->table('configurations');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'existing'
                ]
            ]
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('value');

        $validator
            ->allowEmpty('description');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->boolean('editable')
            ->requirePresence('editable', 'create')
            ->notEmpty('editable');

        $validator
            ->integer('weight')
            ->allowEmpty('weight');

        $validator
            ->boolean('autoload')
            ->allowEmpty('autoload');

        return $validator;
    }
}
