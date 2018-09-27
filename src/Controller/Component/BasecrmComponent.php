<?php
namespace App\Controller\Component;
use Cake\Core\Configure;

use Cake\Controller\Component;
use Cake\Network\Http\Client;
use Cake\ORM\TableRegistry;
use Exception;

require_once(ROOT . DS  . '/vendor' . DS  . 'basecrm' . DS . 'autoload.php');

class BasecrmComponent extends Component
{
    private $client;
    
    public function initialize(array $config){
        $token = Configure::read('basecrmToken');
       //for joyance $this->client = new \BaseCRM\Client(['accessToken' => '3d0d52e1aa2f5740e4eaac27087aa7b19dbfe01f170f4cb574ca11dc5c676eee']);    
        $this->client = new \BaseCRM\Client(['accessToken' => '4d7cc08ec792716514e038b43bc4e84691ca49cadf5183023dcd8ffa0572e5e4']);    
       /*test*/  //$this->client = new \BaseCRM\Client(['accessToken' => 'a8e5e53c49c893170511f77ebd482289af3587d1776eb21d754c47b38b6b712a']);    
    }

    public function createOrganization($comapnyDetail = []){
        try {
            $lead = $this->client->leads->create($comapnyDetail);
          
            
        } 
        catch(Exception $e) {
            $lead['error'] = 'Message: ' .$e->getMessage();
        }
            
       
       return $lead;
    }  


    public function getAll($options = []){
        $leads = $this->client->leads->all($options);
        return $leads;
    } 

    public function getById($id = null){
        $lead = $this->client->leads->get($id);
        return $lead;
    }

    public function deleteOrganizaton($id = null){
        $lead = $this->client->leads->destroy($id);
        return $lead;
    } 

    
    public function addNotes($options = array()){
        $lead = $this->client->notes->create($options);
        return $lead;
    }
}
/* $comapnyDetail = ['organization_name' => 'test','address'=> ['country' => 'us','state' => 'resd','city' => 'abc'],'custom_fields' => ['category' => 'abc'],'first_name' => 'abc','last_name' => 'abc','linkedin' => 'abc','email' => 'adb@adb.com','phone' => '7941648794','description' => 'dsadadsa dsa d d  d ds ds sd d s sd sd ds sd'];*/
