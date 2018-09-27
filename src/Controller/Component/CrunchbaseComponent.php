<?php
namespace App\Controller\Component;
use Cake\Core\Configure;
use Cake\Controller\Component;
use Cake\Network\Http\Client;
use Cake\ORM\TableRegistry;
use Exception;
class CrunchbaseComponent extends Component
{
    protected $base_url = 'https://api.crunchbase.com/v3.1/';
    public function initialize(array $config){
        $this->user_key = Configure::read('crunchbase');
        $this->format   = 'array';
    }

    public function getOrganizations($params = []){
        try {
            extract($params);

        $_query = array();
        if(isset($organization_types) && !empty($organization_types) ){
            $_query['organization_types'] = $organization_types;
        }
        if(isset($categories) && !empty($categories)){
            $_query['categories'] = $categories;
        }
        if(isset($updated_since) && !empty($updated_since)){
            $_query['updated_since'] = $updated_since;
        }
        if(isset($location) && !empty($location)){
            $_query['locations'] = urlencode($location);
        }
        if(isset($page) && !empty($page)){
            $_query['page'] = $page;
        }
        $this->order_by     = isset($order_by) && in_array($order_by, array('created_at', 'created_at', 'updated_at', 'updated_at')) ? $order_by : 'updated_at';
        $this->sort_order   = isset($sort_order) && in_array($sort_order, array('ASC', 'DESC')) ? $sort_order : 'ASC';

        $organisations =  $this->curl_execute($method = 'organizations', $_query);
        } 
        catch(Exception $e) {
             $organisations['error'] = 'Message: ' .$e->getMessage();
        }       
       return $organisations;
    }  

    public function organization($permalink)
    {
        return $this->curl_execute($method = 'organizations', $permalink,'single');
    }
	
    public function getAllFundRound($params = []){
        $funds = [];
        try {
            $_query = $params;
            $funds =  $this->curl_execute($method = 'funding-rounds', $_query);
        } 
        catch(Exception $e) {
            $funds['error'] = 'Message: ' .$e->getMessage();
        }
       return $funds;
    }
    
    public function getFundedEntity($id) {   
            $_query = [];
            $organisations =  $this->curl_execute($method = 'funding-rounds/'.$id.'/funded_organization', $_query);
            return $organisations;
    }

    public function getLocationCountry($params = []) {   
            $_query = [];
            $organisations =  $this->curl_execute($method = 'locations', $_query);
            return $organisations;
    }
    
    

   public function curl_execute($method, $_query, $type = 'all')
    {
        if($type == 'all'){
            $api_url = "{$this->base_url}{$method}?".http_build_query($_query)."&user_key={$this->user_key}";        
        } else {
            $api_url = "{$this->base_url}{$method}/{$_query}?user_key={$this->user_key}";        
        }
        //echo $api_url;
        if (isset($this->order_by) && isset($this->sort_order)){
            $api_url .= "&order={$this->order_by}+$this->sort_order";
            unset($this->order_by);
            unset($this->sort_order);
        }
        
        $ch = curl_init($api_url);
        curl_setopt_array($ch, array(   CURLOPT_RETURNTRANSFER  => TRUE));
        $response       = curl_exec($ch);
            
        $http_status    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status !== 200)
        {
            return "HTTP call failed with error {$http_status}.";
        }
        elseif ($response === FALSE)
        {
            return "HTTP call failed empty response.";
        }        
        return ($this->format === 'json') ? $response : json_decode($response, TRUE);
    }
}
/* $comapnyDetail = ['organization_name' => 'test','address'=> ['country' => 'us','state' => 'resd','city' => 'abc'],'custom_fields' => ['category' => 'abc'],'first_name' => 'abc','last_name' => 'abc','linkedin' => 'abc','email' => 'adb@adb.com','phone' => '7941648794','description' => 'dsadadsa dsa d d  d ds ds sd d s sd sd ds sd'];*/
