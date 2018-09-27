<?php
// src/Model/Table/UsersTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;

class CategoriesTable extends Table {
    public $name = 'categories';
    
     /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');        
    }

    
    public function validationDefault(Validator $validator)
    {
        $validator = new Validator();
        $validator
            ->notEmpty('name', 'Please add category name');

        return $validator;
    }
}