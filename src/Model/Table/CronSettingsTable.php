<?php
// src/Model/Table/UsersTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;

class CronSettingsTable extends Table {
    public $name = 'cron_settings';
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('cron_settings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');        
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator = new Validator();
        $validator
            ->notEmpty('week_day', 'Please add your name')
            ->notEmpty('time_hour', 'Please add your Email')            
            ->notEmpty('time_minute', 'Please add password');

        return $validator;
    }
}