<?php
// src/Model/Table/UsersTable.php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class OrganizationsTable extends Table {
        
     public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('organizations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        $this->hasMany('AllReviews', ['className' => 'OrganizationsReviews']);
        $this->hasMany('AllComments', ['className' => 'OrganizationsComments']);
        $this->hasMany('AllNews', ['className' => 'OrganizationsNews']);
        $this->hasOne('ReviewByUser', ['className' => 'OrganizationsReviews']);
        $this->hasOne('CommentByUser', ['className' => 'OrganizationsComments']);
        $this->addBehavior('Timestamp');    
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator = new Validator();
        $validator
            ->notEmpty('companyid', 'Please add company id')
            ->notEmpty('description', 'Please add description');

        return $validator;
    }
    
    //To save the passed array of data into organization table.
    public function saveOrganization($data) {
        $organizationData = $this->newEntity($data);
        return $save_data = $this->save($organizationData);
    }
    
 }