<?php
// src/Model/Table/UsersTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;

class LogsTable extends Table {
    public $name = 'logs';
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');        
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator = new Validator();
        $validator
            ->notEmpty('type', 'Please add type')
            ->notEmpty('type_id', 'Please add id')            
            ->notEmpty('errorcode', 'please add error code');           

        return $validator;
    }
    
    public function addLog($data) {
        $logData = $this->newEntity($data);
        $save_data = $this->save($logData);
    }
    
}