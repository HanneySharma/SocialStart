<?php
namespace App\Controller\Component;
use Cake\Core\Configure;

use Cake\Controller\Component;
use Cake\Mailer\Email;
use Cake\Network\Http\Client;

// In a controller or table method.
use Cake\ORM\TableRegistry;

class PitchbookComponent extends Component
{
    private $pitchbook_api_url = '';
    private $pitchbook_api_key = '';
    private $http = '';
    
    /**
     * Initialze the api key and url and http request
     *
     * 
     */
    
    public function initialize(array $config){
        
        $this->pitchbook_api_url = Configure::read('pitchbook_api_url');
        $this->pitchbook_api_key = Configure::read('pitchbook_api_key');
        $this->http = new Client();
    }
    
    /**
     * get companies from pitchbook
     *
     * 
     */
    public function getCompaniesSearch($page = 1, $dealDate = "", $verticals = "", $dealType = ""){
        if($dealDate == ""){
            $dealDate = date('Y-m-d', strtotime('-7 days'));
        }
        
        $options = ['page' => $page];        
        if($dealType){
            $options['dealType'] =  $dealType;
        }
        if($verticals){
            $options['verticals'] =  $verticals;
        }

        $this->pitchbook_api_url."/companies/search";
        $response = $this->http->get($this->pitchbook_api_url."/companies/search?dealDate=>".$dealDate, $options, [
                                    'type' => 'json',
                                    'headers' => ['authorization' => "PB-Token ".$this->pitchbook_api_key]
                                    ]);        
        return $response;
    }
    
    /**
     * get company basic details from pitchbook
     *
     * 
     */
    public function getCompanyBasicDetails($companyID = ""){
        if($companyID == ""){
            return false;
        }
                
        $response = $this->http->get($this->pitchbook_api_url."/companies/".$companyID."/basic", [], [
                                    'type' => 'json',
                                    'headers' => ['authorization' => "PB-Token ".$this->pitchbook_api_key]
                                    ]);        
        return $response;
    }
    
    /**
     * get people (CEO) basic details from pitchbook
     *
     * 
     */
    public function getPeopleContactDetails($personId = ""){
        if($personId == ""){
            return false;
        }

        $response = $this->http->get($this->pitchbook_api_url."/people/".$personId."/contactinfo", [], [
                                    'type' => 'json',
                                    'headers' => ['authorization' => "PB-Token ".$this->pitchbook_api_key]
                                    ]);        
        return $response;
    }
    
    
    /**
     * Search people by people ID
     *
     * 
     */
    public function getPeopleSearch($peopleId = ""){
        
        $this->pitchbook_api_url."/people/search";
        $response = $this->http->get($this->pitchbook_api_url."/people/search?personId=".$peopleId, [], [
                                    'type' => 'json',
                                    'headers' => ['authorization' => "PB-Token ".$this->pitchbook_api_key]
                                    ]);        
        return $response;
    }
}
