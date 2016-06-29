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
        $this->addBehavior('Search.Search');
        $this->searchManager()
            ->add('id', 'Search.Value', [
                'field' => $this->aliasField('id')
            ])
            ->add('name', 'Search.Like', [
                'before' => true,
                'after' => true,
                'field' => $this->aliasField('name')
            ])
            ->add('value', 'Search.Value', [
                'field' => $this->aliasField('value')
            ])
            ->add('description', 'Search.Like', [
                'before' => true,
                'after' => true,
                'field' => $this->aliasField('description')
            ])
            ->add('type', 'Search.Like', [
                'before' => true,
                'after' => true,
                'field' => $this->aliasField('type')
            ])
            ->add('editable', 'Search.Value', [
                'field' => $this->aliasField('editable')
            ])
            ->add('weight', 'Search.Value', [
                'field' => $this->aliasField('weight')
            ])
            ->add('autoload', 'Search.Value', [
                'field' => $this->aliasField('autoload')
            ]);
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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
