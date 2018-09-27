<?php
// src/Model/Table/FiltersUsersTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;

class OrganizationsFoundersTable extends Table {
    public $name = 'organizations_founders';
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('organizations_founders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');        
    }
    
    public function validationDefault(Validator $validator)
    {
       $validator = new Validator();
   
         
        
        return $validator;
    }
}