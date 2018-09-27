<?php
// src/Model/Table/FiltersUsersTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;

class OrganizationsInvestorsTable extends Table {
    public $name = 'organizations_investors';
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('organizations_investors');
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