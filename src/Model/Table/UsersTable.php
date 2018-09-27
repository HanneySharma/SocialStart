<?php
// src/Model/Table/UsersTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;

class UsersTable extends Table {
    public $name = 'users';
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');        
        $this->belongsTo('UsersGroups');
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator = new Validator();
        $validator
            ->notEmpty('name', 'Please add your name')
            ->notEmpty('username', 'Please add your Email')            
            ->notEmpty('password', 'Please add password') 
            ->add('confirm_password', [
                '_empty' => [
                'rule' => ['compareWith', 'password'],
                'message' => 'Confirm password does not match with password'
                ]
                ])
            ->add('current_password','custom',[
                'rule'=>  function($value, $context){
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                            return true;
                        }
                    }
                    return false;
                },
                'message'=>'The old password does not match the current password!',
            ])
            ->notEmpty('current_password');

        return $validator;
    }
}