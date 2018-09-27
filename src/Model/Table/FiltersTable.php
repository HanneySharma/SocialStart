<?php
// src/Model/Table/FiltersUsersTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;

class FiltersTable extends Table {
    public $name = 'filters';
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('filters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');        
    }
    
    public function validationDefault(Validator $validator)
    {
       $validator = new Validator();
        $validator
            ->notEmpty('filter_value', 'Please add country');
         
        
        return $validator;
    }
}