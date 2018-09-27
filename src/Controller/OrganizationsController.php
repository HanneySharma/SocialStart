<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use SimpleXlsx\SimpleXlsx;
use ProductHunt\ProductHunt;
use Exception;
use PHPExcel;
use Cake\Mailer\Email;


/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class OrganizationsController extends AppController
{
        

       
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Pitchbook');
        $this->loadComponent('Crunchbase');
        $this->loadComponent('Basecrm');      
        
        error_reporting(E_ALL ^ E_WARNING); 
    }

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $this->loadModel('Verticals');
        $this->loadModel('Logs');
        $this->loadModel('Organizations');
        $this->loadModel('Categories');
        $this->loadModel('Filters');
        $this->loadModel('Countries');
        $this->loadModel('PortfolioCompanies');
        $this->Auth->allow(['cronRun','cleanOrganisationsTable']);
    }

     public function index()
    {   
        /*****Default Options Set******/
        $page = 0;
        $paginationCountChange = 100;
        $functionName = 'index';
        /*****Default Options Set******/
        /*** set search condition ***/
        if ($this->request->is('post') && $this->request->is('ajax') && isset($this->request->data['search']) && !empty($this->request->data['search'])) {
            $conditions['or']['formal_company_name like'] = '%'.$this->request->data['search'].'%';
            $conditions['or']['first_name like'] = '%'.$this->request->data['search'].'%';
            $conditions['or']['last_name like'] = '%'.$this->request->data['search'].'%';
            $conditions['or']['city like'] = '%'.$this->request->data['search'].'%';
            $conditions['or']['state like'] = '%'.$this->request->data['search'].'%';
            $conditions['or']['country like'] = '%'.$this->request->data['search'].'%';            
            $conditions['status !='] = 2;
            $this->request->session()->write('Config.search',$this->request->data['search']);  
        } else {
             $conditions = $this->setConditions($this->request->query);
        }

        if($this->request->query('page') ){
            $page = $this->request->query('page');
            $this->request->session()->write('Config.pageno',$page);  
        }

        /*** set search condition ***/
        $Organizations = $this->Organizations->find()->select(['id','web_path','phone','image','formal_company_name','first_name','last_name','website','description','category','city','state','country','source','companyid'])
        ->contain(['ReviewByUser' => function($q){ return $q->select(['id','organization_id','review','review_joyance'])->where(['ReviewByUser.user_id' => $this->Auth->user('id')]);},'CommentByUser' => function($q){ return $q->select(['id','organization_id','comment'])->where(['CommentByUser.user_id' => $this->Auth->user('id')]); } ])->where([$conditions])->limit($paginationCountChange)->page($page)->group(['formal_company_name'])->order(['Organizations.id' => 'Desc'])->hydrate(false);
        $this->paginate = ['limit' => $paginationCountChange,'order' => ['id' => 'desc']];
        $OrganizationsList = $this->paginate($Organizations);

        /******** Get All countires List*************/
        $country_options_select = array('0'=>'All');
        $country_options_get = $this->Organizations->find('list',['keyField'=>'country','valueField'=>'country'])->where(['status !='=>2])->group('country')->hydrate(false)->toArray();
        $country_options_all = array_merge($country_options_select,array_filter($country_options_get));
        /******** Get All countires List*************/

        $getFundingTypes = array(''=>'Select Funding Type');
        $getFundingTypes1 = $this->Organizations->find('list',['keyField'=>'funding_type','valueField'=>'funding_type'])->group('funding_type')->hydrate(false)->toArray();
        foreach($getFundingTypes1 as $key=>$value){
           $getFundingTypes1[$key] = ucwords(str_replace("_", " ", $value));
        }

        $this->set(compact('OrganizationsList','functionName','country_options_all','getFundingTypes1'));
        if ($this->request->is('ajax')) {
          $this->viewBuilder()->layout(false);
          $this->render('/Element/Organizations/organizations');
        }       
    }


    private function setConditions($queries){
        $conditions = array();
        $conditions['status !='] = 2;
        /*$start_week     = strtotime("last monday midnight");
        $end_week       = strtotime("next sunday",$start_week);
        $start_week     = date("Y-m-d",$start_week);
        $end_week       = date("Y-m-d",$end_week);
        $conditions['DATE(Organizations.created) >='] = $start_week;
        $conditions['DATE(Organizations.created) <='] = $end_week;*/
        if(empty($queries)){            
            $conditions['source'] = 'manual';
        }
        if(!empty($queries)){
            foreach($queries as $queryKey => $queryValue) {
                if(empty($queryValue)){
                    continue;
                }
                if($queryKey == 'source'){
                    $conditions['source'] = $queryValue;
                } else if($queryKey == 'funding_type_any' && $queries['source'] == 'crunchbase'){
                    if(isset($queries['filter_type']) && $queries['filter_type'] != 'any' ){
                        $conditions['funding_type NOT IN'] =  explode(',', $queryValue);
                    } else {
                        $conditions['funding_type IN'] =  explode(',', $queryValue);
                    }
                } else if($queryKey == 'country' && $queryValue !='0'  && $queries['source'] == 'crunchbase'){
                    $conditions['country'] = $queryValue;
                } else if($queryKey == 'search'){
                    $conditions['or']['formal_company_name like'] = '%'.$queryValue.'%';
                    $conditions['or']['first_name like'] = '%'.$queryValue.'%';
                    $conditions['or']['last_name like'] = '%'.$queryValue.'%';
                    $conditions['or']['city like'] = '%'.$queryValue.'%';
                    $conditions['or']['state like'] = '%'.$queryValue.'%';
                    $conditions['or']['country like'] = '%'.$queryValue.'%';
                } else if($queryKey == 'recently_funded'  && $queries['source'] == 'crunchbase'){
                    $days = '-30';
                    if($queryValue == 2) {
                        $days = '-60';
                    } else if($queryValue == 1) {
                        $days = '-90';
                    }
                    $dateTo =date('Y-m-d',strtotime($days.' days'));
                    $conditions['DATE(announced_on) >=']= $dateTo;
                }   
            }
        }       
        $this->request->session()->write('Config',$conditions);  
        return $conditions;
    }

    public function organization($id = null)
    {
        $this->loadModel('Organizations');
        $organizationsObj = $this->Organizations->newEntity();
        $listOrgCountry = $this->Countries->find('list',['keyField'=>'name','valueField'=>'name'])->hyDrate(false)->toArray(); 
        $country_options_all=array(''=>'Select Country');
        foreach($listOrgCountry as $key=>$value){
            $country_options_all[$key] = $value;
        }
       
        if($this->request->is('post')) {
            $organizationsEntity = $this->Organizations->patchEntity($organizationsObj , $this->request->data);
            if($this->Organizations->save($organizationsEntity)){
                $message = "Organization is saved successfully";
                $redirect = '';
                if($id != null){
                    $redirect = $id;
                    $message = "Organization is edited successfully";
                }
                $this->Flash->custom_success(__($message));
                $this->redirect(['action' => 'organization',$redirect]);
                return;
            }
        }
        if($id != null){
            $this->request->data = $this->Organizations->find()->where( [ 'id' => $id ] )->hydrate( false )->first();
        }
        $categories = $this->Categories->find('list',['keyField' => 'id','valueField' => 'name'])->hydrate( false )->toArray();

        $this->set( compact( 'organizationsObj','categories','country_options_all') );
    }


    public function reviews( ) {
        if( $this->request->is( 'ajax' ) && $this->request->is( 'post' ) ) {
            $this->viewBuilder( )->layout( false );
            $this->autoRender = false;
            
            
            $this->loadModel( 'OrganizationsReviews' );
            
            if($this->request->data[ 'review' ] != 2){
                if(empty($this->request->data['id'])){
                    unset($this->request->data['id']);
                }
                //$this->OrganizationsReviews->deleteAll(['organization_id'=>$this->request->data[ 'organization_id' ],'user_id'=>$this->Auth->user( 'id' )] );
                $this->request->data[ 'user_id' ]  = $this->Auth->user( 'id' );
                $this->request->data[ 'created' ]  = date('Y-m-d H:i:s');
                $this->request->data[ 'modified' ] = date('Y-m-d H:i:s');
                if($this->request->data[ 'review' ] == 0){
                    $this->request->data[ 'review_joyance' ] = 0;
                }
                if($this->request->data['platform'] == 'joyance') {
                    $this->request->data[ 'review_joyance' ] = $this->request->data[ 'review' ];
                    unset($this->request->data[ 'review' ]);
                }

                $OrganizationsReviewsEnt = $this->OrganizationsReviews->newEntity( $this->request->data );
                $saveData = $this->OrganizationsReviews->save( $OrganizationsReviewsEnt );
                if( $saveData ) {
                    $id = $saveData->toArray()['id'];
                    echo json_encode( array( 'status' => 1, 'id' =>$id ) );
                } else {
                    echo json_encode( array( 'status' => 0, 'id' =>$id ) );
                }
            } else {
               // deleteAll(['status' => 2]);$OrganizationsReviewsEnt = $this->OrganizationsReviews->get($this->request->data[ 'id' ]);
                if( $this->OrganizationsReviews->deleteAll(['organization_id'=>$this->request->data[ 'organization_id' ]] )) {
                    echo json_encode( array( 'status' => 1 ) );
                } else {
                    echo json_encode( array( 'status' => 0 ) );
                }
            }         
        }
    }
    
     public function reviewsDetails( ) {
        if( $this->request->is( 'ajax' ) && $this->request->is( 'post' ) ) {
            $this->viewBuilder( )->layout( false );
            $this->autoRender = false;
            
            
            $this->loadModel( 'OrganizationsReviews' );
            
            if($this->request->data[ 'review' ] != 2){
                $this->OrganizationsReviews->deleteAll(['organization_id'=>$this->request->data[ 'organization_id' ],'user_id'=>$this->Auth->user( 'id' )] );
                $this->request->data[ 'user_id' ]  = $this->Auth->user( 'id' );
                $this->request->data[ 'created' ]  = date('Y-m-d H:i:s');
                $this->request->data[ 'modified' ] = date('Y-m-d H:i:s');
                $OrganizationsReviewsEnt = $this->OrganizationsReviews->newEntity( $this->request->data );
                $saveData = $this->OrganizationsReviews->save( $OrganizationsReviewsEnt );
                if( $saveData ) {
                    $id = $saveData->toArray()['id'];
                    echo json_encode( array( 'status' => 1, 'id' =>$id ) );
                     
                } else {
                    echo json_encode( array( 'status' => 0, 'id' =>$id ) );
                }
            } else {
               // deleteAll(['status' => 2]);$OrganizationsReviewsEnt = $this->OrganizationsReviews->get($this->request->data[ 'id' ]);
                if( $this->OrganizationsReviews->deleteAll(['organization_id'=>$this->request->data[ 'organization_id' ]] )) {
                   
                    echo json_encode( array( 'status' => 1 ) );
                } else {
                    echo json_encode( array( 'status' => 0 ) );
                }
            }            
        }
    }
    /*
    * Author: TeqMavens
    * Description: Search the Pitchbook and save all organization details along with people information
    * Return:
    */
    public function searchCompaniesPitchbook($page = 1, $verticals = array(), $dealType = "", $deal_date = ""){
        $dealDate = date('Y-m-d', strtotime('-800 days'));
        $verticals = implode(',', $verticals);
        $pitchBookResult = $this->Pitchbook->getCompaniesSearch($page, $dealDate, $verticals, $dealType);
        $resultpitchBookResult = array();
        if($pitchBookResult->code == 200){
            $resultpitchBookResult1 = $pitchBookResult->json;
            foreach ($resultpitchBookResult1['results']['items'] as $key => $value) {
                $resultpitchBookResult[] = $value;
            }
            if(!empty($resultpitchBookResult1) && $resultpitchBookResult1['results']['stats']['lastPage'] > 1){
                for ($i = 2 ; $i <= $resultpitchBookResult1['results']['stats']['lastPage']; $i++) {
                    $pitchBookResult = $this->Pitchbook->getCompaniesSearch($i, $dealDate, $verticals, $dealType);
                    if($pitchBookResult->code == 200){
                        $resultpitchBookResult2 = $pitchBookResult->json;
                        foreach ($resultpitchBookResult2['results']['items'] as $key => $value) {
                            $resultpitchBookResult[] = $value;
                        }
                    }
                }
            }
        } else {
            $resultpitchBookResult = $pitchBookResult->json;
            $logData = array('type'=>'Company Search', 'type_id'=>"Last 7 days based", 'errorcode'=>$pitchBookResult->code."  -  ".$resultpitchBookResult['message']);
            $this->Logs->addLog($logData);
        }
        if(!empty($resultpitchBookResult)) {
             foreach($resultpitchBookResult as $companies){
                if($companies=='401'){
                    echo "unauthorized";die;
                   
                }
                else {
                    $insertOrganization = 1;
                    $companyId = $companies['companyId'];
                    if(!$this->Organizations->exists(array("companyid" => $companyId))){
                        $companyBasicDetails = $this->Pitchbook->getCompanyBasicDetails($companyId);

                        if($companyBasicDetails){

                            if($companyBasicDetails->code == 200){
                                $companyBasicDetailsresult = $companyBasicDetails->json;

                                $description = $companyBasicDetailsresult['description']['short'];
                                $city = "";
                                $country = "";
                                $state = "";
                                foreach ($companyBasicDetailsresult['locations'] as $key => $location) {
                                    if($location['type'] == "Primary HQ"){
                                        $city = $location['address']['city'];
                                        $country = $location['address']['country'];
                                        $state = $location['address']['stateProvince'];
                                    }
                                }
                                $verticals = [];
                                if(!empty($companyBasicDetailsresult['verticals']) ){
                                    foreach ($companyBasicDetailsresult['verticals'] as $key => $vertical) {
                                        $verticals[] = $vertical['code'];
                                    }
                                }
                                if(!empty($verticals)){
                                    $vertl = implode(', ', $verticals);
                                } else {
                                    $vertl = '';
                                }

                                $formal_company_name = $companyBasicDetailsresult['companyName']['formal'];
                                $legal_company_name = $companyBasicDetailsresult['companyName']['legal'];
                                $website = "";
                                if(array_key_exists(0, $companyBasicDetailsresult['website'])){
                                    $website = $companyBasicDetailsresult['website'][0]['url'];
                                }
                                $personId = "";
                                $email = "";
                                $phone = "";
                                $first_name = "";
                                $last_name = "";

                                if(is_array($companyBasicDetailsresult['primaryContact']) && count($companyBasicDetailsresult['primaryContact']) > 0){
                                    $personId = $companyBasicDetailsresult['primaryContact']['personId'];
                                    $first_name = $companyBasicDetailsresult['primaryContact']['personName']['first'];
                                    $last_name = $companyBasicDetailsresult['primaryContact']['personName']['last'];
                                    if($companyBasicDetailsresult['primaryContact']['contactInfo']){
                                        $peopleContactDetails = $this->Pitchbook->getPeopleContactDetails($personId);
                                        if($peopleContactDetails){
                                            if($peopleContactDetails->code == 200){
                                                $peopleContactDetailsresult = $peopleContactDetails->json;
                                                if($peopleContactDetailsresult['contactInformation'] != null){
                                                    $email = $peopleContactDetailsresult['contactInformation']['email'];
                                                }
                                                if($peopleContactDetailsresult['contactInformation'] != null){
                                                    $phone = $peopleContactDetailsresult['contactInformation']['phone'];
                                                }
                                            }else{
                                                $peopleContactDetailsResult = $peopleContactDetails->json;
                                                $logData = array('type'=>'Person Profile Contacts', 'type_id'=>$personId, 'errorcode'=>$peopleContactDetails->code."  -  ".$peopleContactDetailsResult['message']);
                                                $this->Logs->addLog($logData);
                                            }
                                        }else{
                                            $insertOrganization = 0;
                                            $logData = array('type'=>'Person Profile Contacts', 'type_id'=>$personId, 'errorcode'=>'person ID not passed');
                                            $this->Logs->addLog($logData);
                                        }
                                    }
                                }

                            } else {
                                $companyBasicDetailsResult = $companyBasicDetails->json;
                                $insertOrganization = 0;
                                $logData = array('type'=>'Company profile basic info', 'type_id'=>$companyId, 'errorcode'=>$companyBasicDetails->code."  -  ".$companyBasicDetailsResult['message']);
                                $this->Logs->addLog($logData);
                            }
                        }else{
                            $insertOrganization = 0;
                            $logData = array('type'=>'Company profile basic info', 'type_id'=>$companyId, 'errorcode'=>"company ID not passed");
                            $this->Logs->addLog($logData);
                        }

                        if($insertOrganization){
                            $organizationData = array('companyid'           =>  $companyId,
                                                    'formal_company_name'   =>  $formal_company_name,
                                                    'legal_company_name'    =>  $legal_company_name,
                                                    'first_name'            =>  $first_name,
                                                    'last_name'             =>  $last_name,
                                                    'email'                 =>  $email,
                                                    'phone'                 =>  $phone,
                                                    'description'           =>  $description,
                                                    'city'                  =>  $city,
                                                    'state'                 =>  $state,
                                                    'country'               =>  $country,
                                                    'personid'              =>  $personId,
                                                    'website'               =>  $website,
                                                    'verticals'             =>  $vertl,
                                                    'source'                => 'pitchbase'
                                                );
                            $saveOrganizationResult = $this->Organizations->saveOrganization($organizationData);
                        }
                    }else{
                        $logData = array('type'=>'Company ID already exists', 'type_id'=>$companyId, 'errorcode'=>'Company ID exists in Database');
                        $this->Logs->addLog($logData);
                    }
                }
            }
        }
    }


    public function addComments()
    {  
        $this->loadModel('Users');
        if($this->request->is('post')){
            $this->autoRender = false;
            $this->viewBuilder()->layout(false);
            $this->loadModel('OrganizationsComments');
            $this->request->data['user_id'] = $this->Auth->user('id');
            $getUser = $this->Users->find('all')->where(['id'=>$this->Auth->user('id')])->hydrate( false )->first();
            $getComment = $this->OrganizationsComments->find('all')->where(['user_id'=>$this->Auth->user('id'),'organization_id'=>$this->request->data('organization_id')])->hydrate( false )->first();
          
            if(!empty($getComment)){
                
                 $this->request->data[ 'id' ]=$getComment['id']; 
            }
           
            $this->request->data[ 'created' ]  = date('Y-m-d H:i:s');
            $this->request->data[ 'modified' ] = date('Y-m-d H:i:s');
            
      
            $OrganizationsCommentsEntity =     $this->OrganizationsComments->newEntity($this->request->data);
            
            if($this->OrganizationsComments->save($OrganizationsCommentsEntity)){
                echo json_encode(array('status' =>1,'comment'=>$this->request->data('comment'),'name'=>$getUser['name']));
            } else {
                echo json_encode(array('status' =>0));
            }
        }
    }


    public function detail($id = null)
    {
        if($id != null){
            $this->loadModel('Organizations');
            $this->loadModel('OrganizationsReviews');
            $this->loadModel('Users');
            
            if($this->Auth->user('role') == 1){
                $Organizations = $this->Organizations->find()->select()->contain([
                    'AllReviews' => function($q){
                        return $q->select(['id','organization_id','review','review_joyance', 'user_id', 'created'])->order(['AllReviews.created' => 'Desc']);
                    },
                    'AllReviews.Users' => function($q){
                        return $q->select(['id','name']);
                    },
                      'CommentByUser' => function($q){
                        return $q->select(['id','organization_id','comment'])->where(['CommentByUser.user_id' => $this->Auth->user('id')]);
                        },      
                    'AllComments.Users' => function($q){
                        return $q->select(['id','name']);
                    },
                    'AllComments' => function($q){
                        return $q->select(['id','organization_id','comment', 'created'])->order(['AllComments.created' => 'Desc']);
                    },
                    'AllNews'=>function($q){
                        return $q->select(['id','title','url','organization_id','posted_on'])->order(['AllNews.id'=>'DESC']);
                    }
                ])->where(['Organizations.id' => $id])->hydrate(false)->first();
            } else {
                $Organizations = $this->Organizations->find()->select()->contain([
                    'AllReviews' => function($q){
                        return $q->select(['id','organization_id','review','review_joyance', 'user_id', 'created'])->where(['AllReviews.user_id' => $this->Auth->User('id')])->order(['AllReviews.created' => 'Desc']);
                    },
                    'AllReviews.Users' => function($q){
                        return $q->select(['id','name']);
                    },
                    'CommentByUser' => function($q){
                        return $q->select(['id','organization_id','comment'])->where(['CommentByUser.user_id' => $this->Auth->user('id')]);
                        },        
                    'AllComments.Users' => function($q){
                        return $q->select(['id','name']);
                    },
                    'AllComments' => function($q){
                        return $q->select(['id','organization_id','comment', 'created'])->where(['AllComments.user_id' => $this->Auth->user('id')])->order(['AllComments.created' => 'Desc']);
                    },
                     'AllNews'=>function($q){
                        return $q->select(['id','title','url','organization_id','posted_on']);
                    }
                ])->where(['Organizations.id' => $id])->hydrate(false)->first();
            }
            //date format
            $user_id =  $this->request->session()->read('Auth.Admin.id');
            $message = 'date  format added successfully';
            $getDate = $this->Users->find()->where( [ 'id' => $user_id ] )->hydrate( false )->first();
            $userReview = $this->OrganizationsReviews->find()->select(['id','review','review_joyance'])->where(['organization_id' => $id, 'user_id' => $this->Auth->user('id')])->hydrate(false)->first();

            $this->set(compact('Organizations', 'userReview','getDate'));

        }
    }


    public function getProductHunt($page = 1){
        $this->autoRender = false;
        $this->viewBuilder()->layout(false);
        ini_set('memory_limit', '200M');
        require_once(ROOT . '/vendor' . DS  . 'ProductHunt'. DS . 'ProductHunt.php');
        $client_id ='ebf4baa57eaefc922fce54af36ee2e6e0e040f5ddcd94b5145594744ec5b7224';
        $client_secret ='76c273b6f8ac51b5435c69babfbf18b0e89dd183631fce6c955e0f20e99bcc29';
        $productHunt = new ProductHunt($client_id,$client_secret);
        $posts = $productHunt->getClientLevelToken();
        $newestPosts = $productHunt->getNewestPosts(array('page' => $page,'sort_by' => 'created_at','order' => 'desc'));
        $portfolioCmps = $this->PortfolioCompanies->find('list',['keyField' => 'id', 'valueField' => 'company'])->hydrate(false)->toArray();
        $count=0;
        $previous_week  = strtotime("-1 week +2 day");
        $start_week = strtotime("last monday midnight",$previous_week);
        $date;
        $orgDetail = array();
        foreach($newestPosts->posts as $key => $postNews){
            if(in_array($this->removeBinary($postNews->name), $portfolioCmps) || $postNews->votes_count < 250){
                continue;
            }
            $countUrl=1;
            $date = strtotime($postNews->day);
            if(!$this->Organizations->exists(["companyid" => $postNews->id, "source" => 'producthunt'] ))
            {
                $weburl_redirect='';
                if(!empty($postNews->screenshot_url)){
                    foreach($postNews->screenshot_url as $webUrl){
                        if($countUrl==1) {
                            $stringUrl =  parse_url($webUrl, PHP_URL_QUERY);
                            $webUrl = explode("&url=",$stringUrl);
                            $weburl_redirect = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($webUrl[1])); 
                            $weburl_redirect = html_entity_decode($weburl_redirect,null,'UTF-8');
                        }
                        $countUrl++;
                    }
                }
                $orgDetail[$count]['companyid'] = $postNews->id;
                $orgDetail[$count]['formal_company_name'] = $this->removeBinary($postNews->name);
                $orgDetail[$count]['description'] = $this->removeBinary($postNews->tagline);
                $orgDetail[$count]['image'] = $this->removeBinary($postNews->thumbnail->image_url);
                $orgDetail[$count]['web_path'] =$this->removeBinary($postNews->discussion_url);
                $orgDetail[$count]['website'] =$this->removeBinary($weburl_redirect);
                $orgDetail[$count]['source'] = 'producthunt';
                if(isset($postNews->user->name) && !empty($postNews->user->name)){
                    $name= explode(" ",$this->removeBinary($postNews->user->name));
                    if(isset($name[0]) && !empty($name[0]) ) {
                        $orgDetail[$count]['first_name'] = $this->removeBinary($name[0]);
                    } 
                    if(isset($name[1]) && !empty($name[1])){
                         $orgDetail[$count]['last_name'] = $this->removeBinary($name[1]);
                    }
                    
                }
                $orgDetail[$count]['updated_since'] = date('Y-m-d H:i:s',strtotime($postNews->created_at));
                $count++;
                unset($org);
            }
        }
        if(!empty($orgDetail)){
            $entities = $this->Organizations->newEntities($orgDetail);
            $result = $this->Organizations->saveMany($entities);
        }
        if($date >= $start_week){
            $this->getProductHunt($page+1);
        }
        unset($orgDetail);
        unset($previous_week);
        unset($date);
     // echo "success";
     }
     
     /*
      * function to check for binary values
      */
     function removeBinary($str) {
                       return preg_replace('/[\x00-\x1F\x7F-\xFF]/', '',$str);
        }
    
    
    /*
    * Author: Hanney Sharma
    * Description: Remove Organizaton from baseCrm.
    * Url: https://developers.getbase.com/docs/rest/reference/leads
    * Return: array of lead informaton
    */
    
    
    public function chruchbaseOrganizatons($categoriesData = array(), $date = '',$type = '', $location = '')
    {  
       
        try
        {   
            //$categoriesData = implode(', ', $categoriesData);
            $dealDate = strtotime('-1 days');
            $this->autoRender = false;
            $this->viewBuilder()->layout(false);

            $listCountry = $this->Filters->find('list',['keyField'=>'filter_value','valueField'=>'filter_value'])->where(['status'=>0])->hyDrate(false)->toArray();
   
            $this->Filters->deleteAll(['status' => 2]);

               $portfolioCmps = $this->PortfolioCompanies->find('list',['keyField' => 'id', 'valueField' => 'company'])->hydrate(false)->toArray();
            if(!empty($listCountry)){
              
               // $this->Filters->updateAll(['status' => 1],['filter_value in' => $listCountry]);
            }
            $country_options_all = [];
            if(isset($listCountry['all']))
            {
                $getCountryList = $this->Countries->find('list',['keyField'=>'name','valueField'=>'name'])->hydrate(false)->toArray();
                foreach($getCountryList as $key=>$value){
                    $country_options_all[$key] = $value;
                }
            } 
            else {
                foreach($listCountry as $key=>$value)
                {
                    $country_options_all[$key] = $value;
                }
            }
           
            foreach($country_options_all as $value){
                
                foreach($categoriesData as $catValue){
              
                    $options = ['organization_types'=>'company','categories' => $catValue,'updated_since' => $dealDate,'page' => 1,'location' => $value];
                    $Organizationdtl = $this->Crunchbase->getOrganizations($options); 
                   
                    if(!isset($Organizationdtl['data']['items']) || empty($Organizationdtl['data']['items']) )
                    {
                    continue;
                    }

                    $numberofpages =  $Organizationdtl['data']['paging']['number_of_pages']; 
                    for ($i = 0; $i <= $numberofpages;  $i++)
                    {

                    $options = ['organization_types'=>'company','categories' => $catValue,'updated_since' => $dealDate,'location' => $value,'page' => $i];
                    $Organizationinner = $this->Crunchbase->getOrganizations($options);
                 
                    if(!isset($Organizationinner['data']['items']) || empty($Organizationinner['data']['items']) )
                    {
                       continue;
                    }
                    foreach($Organizationinner['data']['items'] as $Organization)
                    {
                    
                       $orgDetail = array();
                       if(!$this->Organizations->exists(["companyid" => $Organization['uuid'], "source" => 'crunchbase'] ))
                       {
                         if(in_array($Organization['properties']['name'], $portfolioCmps)){
                            continue;
                          }
                          $orgDetail['companyid'] = $Organization['uuid'];
                          $orgDetail['formal_company_name'] = $Organization['properties']['name'];
                          $orgDetail['description'] = $Organization['properties']['short_description'];
                          $orgDetail['linkedin'] = $Organization['properties']['linkedin_url'];
                          $orgDetail['image'] = $Organization['properties']['profile_image_url'];
                          $orgDetail['web_path'] = $Organization['properties']['web_path'];
                          $orgDetail['website'] = $Organization['properties']['homepage_url'];
                          $orgDetail['source'] = 'crunchbase';
                          $orgDetail['country'] = $Organization['properties']['country_code'];
                          $orgDetail['city'] = $Organization['properties']['city_name'];
                          $orgDetail['permalink'] = $Organization['properties']['permalink'];
                          $orgDetail['state'] = $Organization['properties']['region_name'];
                          $orgDetail['stock_exchange'] = $Organization['properties']['stock_exchange'];
                          $orgDetail['stock_symbol'] = $Organization['properties']['stock_symbol'];
                          $orgDetail['category'] = $catValue;
                          $orgDetail['api_url'] = $Organization['properties']['api_url'];
                          $orgDetail['updated_since'] = date('Y-m-d H:i:s',$Organization['properties']['updated_at']);
                          $org = $this->Organizations->newEntity($orgDetail);
                          $this->Organizations->save($org);
                          $orgDetail = null;
                          $org = null;
                          $OrganizationDetail = null;
                          //unset($orgDetail);
                          // unset($org);
                           //unset($OrganizationDetail);
                       }
                    }
                    }

                    }
              
               
               
               
            }
           
            $this->updatechruchbaseOrganizatons();
            echo "success";
            
        }
        catch(Exception $e)
        {
            echo "Error Message ".$e->getMessage();
            //$this->redirect(['controller'=>'social','action' => 'index']);
            $logs = $this->Logs->newEntity();
            $logs->type = 'Crunchbase get Organization';
            $logs->errorcode    = $e->getMessage();
            $logs->type_id      =  'Organization';
            $logs->created      = date('Y-m-d H:i:s');
            $logs->modified     = date('Y-m-d H:i:s');
            $this->Logs->save($logs);
        }
       
    }
    
   public function updatechruchbaseOrganizatons()
    {  
        $this->loadModel('OrganizationsFounders');
        $this->loadModel('OrganizationsInvestors');
        $this->loadModel('OrganizationsNews');
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $datebefore7 = date('Y-m-d',strtotime('-1 days'));
        $permalink = $this->Organizations->find('list',['keyField' => 'id', 'valueField' => 'permalink'])->where(['created >='=>$datebefore7])->group('companyid')->hydrate(false)->toArray();
        $permalink=array_filter($permalink);
        $announced_on       =   strtotime('-3 months');     
        foreach($permalink as $key=>$valPermalink){
               
                $orgDetail=array();
                $OrganizationDetail = $this->Crunchbase->organization($valPermalink);
                $foundingMembers=array();
                $investorMember=array();
                $listNews=array();
                /*if(!empty($OrganizationDetail['data']['relationships']['founders'])){
                    $this->OrganizationsFounders->deleteAll(['organization_id'=>$key]);
                   
                     $totalFounders = $OrganizationDetail['data']['relationships']['founders']['paging']['total_items'];
                     
                    for($count=0;$count<$totalFounders;$count++){
                        
                            $foundingMembers['organization_id'] = $key;
                             if(!empty($OrganizationDetail['data']['relationships']['founders']['items'][$count]['properties']['first_name']))
                            {
                                    $foundingMembers['first_name'] = $this->removeBinary($OrganizationDetail['data']['relationships']['founders']['items'][$count]['properties']['first_name']);
                            }  
                                if(!empty($OrganizationDetail['data']['relationships']['founders']['items'][$count]['properties']['last_name']))
                            {
                                    $foundingMembers['last_name'] = $this->removeBinary($OrganizationDetail['data']['relationships']['founders']['items'][$count]['properties']['last_name']);
                            } 
                    
              
                        $orgfounder = $this->OrganizationsFounders->newEntity($foundingMembers);
                        $this->OrganizationsFounders->save($orgfounder);
                    
                   }
                    
                    
                }
              
                if(!empty($OrganizationDetail['data']['relationships']['investors']['items'])){
                    $this->OrganizationsInvestors->deleteAll(['organization_id'=>$key]);
                      $totalInvestors = $OrganizationDetail['data']['relationships']['investors']['paging']['total_items'];
                        $investorMember['organization_id'] = $key;
                    for($count=0;$count<$totalInvestors;$count++){
                       
                             if(!empty($OrganizationDetail['data']['relationships']['investors']['items'][$count]['properties']['name']))
                {
                        $investorMember['name'] = $OrganizationDetail['data']['relationships']['investors']['items'][$count]['properties']['name'];
                       
                }
                if(!empty($OrganizationDetail['data']['relationships']['investors']['items'][$count]['properties']['number_of_investments']))
                {
                 $investorMember['number_of_investments'] = $OrganizationDetail['data']['relationships']['investors']['items'][$count]['properties']['number_of_investments'];

                }
                
                       $orginvestor = $this->OrganizationsInvestors->newEntity($investorMember);
                        $this->OrganizationsInvestors->save($orginvestor);
                        
                    }
                    
                    
                }*/
                 if(isset($OrganizationDetail['data']['relationships']['news']['items']) && !empty($OrganizationDetail['data']['relationships']['news']['items'])){
                     if(!empty($OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['funding_type'])  && ($OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['funding_type']=='angel' || $OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['funding_type']=='seed')){
                            $this->OrganizationsNews->deleteAll(['organization_id'=>$key]);
                            $totalNews = $OrganizationDetail['data']['relationships']['news']['paging']['total_items'];

                            for($count=0;$count<3;$count++){

                                if(!empty($OrganizationDetail['data']['relationships']['news']['items'][$count]['properties']['title']))
                                    {
                                          $listNews['title'] = $OrganizationDetail['data']['relationships']['news']['items'][$count]['properties']['title'];           
                                    }
                                    if(!empty($OrganizationDetail['data']['relationships']['news']['items'][$count]['properties']['url']))
                                    {
                                          $listNews['url'] = $OrganizationDetail['data']['relationships']['news']['items'][$count]['properties']['url'];           
                                    }
                                     if(!empty($OrganizationDetail['data']['relationships']['news']['items'][$count]['properties']['posted_on']))
                                    {
                                          $listNews['posted_on'] = $OrganizationDetail['data']['relationships']['news']['items'][$count]['properties']['posted_on'];           
                                    }
                                $listNews['organization_id'] = $key;
                                $listNews['funding_type'] = $OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['funding_type'];

                                $orgNews= $this->OrganizationsNews->newEntity($listNews);
                                $this->OrganizationsNews->save($orgNews);

                            }  
                     }
                    
                    
                    
                }
               
                $categories = [];
                $orgDetail['category'] = '';
                if(isset($OrganizationDetail['data']['properties']['founded_on']))
                {
                    $orgDetail['founded_on'] = $OrganizationDetail['data']['properties']['founded_on'];
                }
                 if(isset($OrganizationDetail['data']['properties']['total_funding_usd']))
                {
                    $orgDetail['total_funding_usd'] = $OrganizationDetail['data']['properties']['total_funding_usd'];
                }
               
         

                if(!empty($OrganizationDetail['data']['relationships']['founders']['paging']['total_items']) && ($OrganizationDetail['data']['relationships']['founders']['paging']['total_items'] > 0 ))
                {

                    $orgDetail['first_name'] = $this->removeBinary($OrganizationDetail['data']['relationships']['founders']['items'][0]['properties']['first_name']);
                    $orgDetail['last_name']  =  $this->removeBinary($OrganizationDetail['data']['relationships']['founders']['items'][0]['properties']['last_name']);
                    $orgDetail['personid']   =   $OrganizationDetail['data']['relationships']['founders']['items'][0]['properties']['permalink'];
                }

                if(!empty($OrganizationDetail['data']['relationships']['categories']['paging']['total_items']) && ($OrganizationDetail['data']['relationships']['categories']['paging']['total_items'] > 0) )
                {
                    foreach ($OrganizationDetail['data']['relationships']['categories']['items'] as $cat) {
                        $categories[] =  $cat['properties']['name'];
                    }
                    $orgDetail['category'] = implode(',', $categories);
                }

                if(!empty($OrganizationDetail['data']['relationships']['headquarters']['paging']['total_items']) && ($OrganizationDetail['data']['relationships']['headquarters']['paging']['total_items'] > 0 ))
                {
                    $orgDetail['address'] = (isset($OrganizationDetail['data']['relationships']['headquarters']['item'][0]['properties']['street_1']))?$OrganizationDetail['data']['relationships']['headquarters']['item'][0]['properties']['street_1'] : $OrganizationDetail['data']['relationships']['headquarters']['item']['properties']['street_1'];
                    $orgDetail['city'] = (isset($OrganizationDetail['data']['relationships']['headquarters']['item'][0]['properties']['city']))?$OrganizationDetail['data']['relationships']['headquarters']['item'][0]['properties']['city'] : $OrganizationDetail['data']['relationships']['headquarters']['item']['properties']['city'];
                    $orgDetail['state'] = (isset($OrganizationDetail['data']['relationships']['headquarters']['item'][0]['properties']['region']))? $OrganizationDetail['data']['relationships']['headquarters']['item'][0]['properties']['region'] : $OrganizationDetail['data']['relationships']['headquarters']['item']['properties']['region'];
                    //$orgDetail['country'] = (isset($OrganizationDetail['data']['relationships']['headquarters']['item'][0]['properties']['country']))? $OrganizationDetail['data']['relationships']['headquarters']['item'][0]['properties']['country'] : $OrganizationDetail['data']['relationships']['headquarters']['item']['properties']['country'];
                }
                if(!empty($OrganizationDetail['data']['relationships']['funding_rounds']['paging']['total_items']) && ($OrganizationDetail['data']['relationships']['funding_rounds']['paging']['total_items'] > 0 ))
                {

                    $orgDetail['announced_on'] = $OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['announced_on'];
                    $orgDetail['money_raised'] = $OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['money_raised'];

                }  
               
            if(!empty($OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['announced_on']) && ($OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['announced_on']> 0 ))
                {
                    $orgDetail['announced_on']=$OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['announced_on'];
                }
            if(!empty($OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['funding_type']))
                {
                    $orgDetail['funding_type']=$OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['funding_type'];
                }
                
             
            if(isset($OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['announced_on']) &&  (strtolower($OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['funding_type']) == 'angel') && (strtotime($OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['announced_on']) >= $announced_on)) {   
                   
                     $orgDetail['recently_funded']=1;
                   
                 }
                 
                // if(!empty($OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['announced_on']) && (strtotime($OrganizationDetail['data']['relationships']['funding_rounds']['items'][0]['properties']['announced_on']) >= $announced_on))
                //{
                                       
                        $this->Organizations->updateAll($orgDetail,['permalink' => $valPermalink ]);
                
               // }   
        unset($OrganizationDetail);
        unset($orgDetail);
                
                
                }
     
        
        
       
    }
    




    private function getDupicateOrganisation(){
        $ids4Duplicate = $this->Organizations->find('list',['keyField' => 'id', 'valueField' => 'formal_company_name'])->group('formal_company_name HAVING COUNT(id) > 1')->order(['id'])->hydrate(false)->toArray();
        $finalIds = array();
        if(!empty($ids4Duplicate)){
            $records4Duplicate1 = $this->Organizations->find('list',['keyField' => 'id', 'valueField' => 'formal_company_name'])->where(['formal_company_name in' =>$ids4Duplicate ])->order(['formal_company_name' => 'Desc'])->hydrate(false)->toArray();
            $records4Duplicate=array();
            foreach($records4Duplicate1 as $key=>$value){
                $records4Duplicate[$key] = ucfirst($value);
            }
            $filtered = array_unique($records4Duplicate);
            foreach ($filtered as $key => $value) {
                $finalIds[$value] = array_keys( $records4Duplicate,ucwords($value));

            }
        return $finalIds;
        }
    }

    public function orgsCat(){
       

        for ($i=1; $i <= 8; $i++) {
            $apiUrl='https://api.crunchbase.com/v3.1/categories?page='.$i.'&user_key=45e31fa2c0e3d47065ebb1beea8a1825';
            $ch = curl_init($apiUrl);
            curl_setopt_array($ch, array(CURLOPT_RETURNTRANSFER  => TRUE));
            $response       = curl_exec($ch);
            $cat = json_decode($response, true);
            foreach($cat['data']['items'] as $categ) {
                 if(!$this->Categories->exists(["name" => $categ['properties']['name']] )){
                    $data  = ['name' => $categ['properties']['name'],'status' => 0,'created' => date('y-d-m H:i:s'),'modified' => date('y-d-m H:i:s')];
                    $dataEnt = $this->Categories->newEntity($data);
                    $this->Categories->save($dataEnt);
                }
            }
        }
        die;
    }




     /*
    * Author: Hanney Sharma
    * Description: Create new record on baseCrm. need to create array in proper format as given
    * Url: https://developers.getbase.com/docs/rest/reference/leads
    * Return: Saved lead info array
    */

    public function basecrmCreateOrganizaton($ids = array()){

        $Organizations = $this->Organizations->find()->contain(['AllReviews' => function($q){
            return $q->select(['organization_id','review', 'review_joyance']);
        },'AllComments' =>  function($q){
            return $q->select(['organization_id','user_id','comment','created']);
        },'AllComments.Users' =>  function($q){
            return $q->select(['id','name']);
        }])->where(['id in' => $ids])->hydrate(false)->toArray();
        $errors = array();
   
        foreach ($Organizations as $key => $Organization) {

            $up = $down = $tiresiasReviews = $joyanceReview = $totalReviews = 0;
            foreach ($Organization['all_reviews'] as $key => $rev) {
                if($rev['review'] == 0 && $rev['review_joyance'] == 0){
                    $down++;
                    $totalReviews ++;
                }
                if($rev['review'] == 1)
                {
                    $up++;
                    $tiresiasReviews++;
                    $totalReviews ++;
                } 
                if($rev['review_joyance'] == 1)
                {
                    $joyanceReview++;
                    $totalReviews ++;
                }
            }
           $comapnyDetail = [
                'organization_name' => $Organization['formal_company_name'],
                'address'           => ['country' => $Organization['country'], 'state' => $Organization['state'], 'city' => $Organization['city']],
                'first_name'        => (!empty($Organization['first_name']))? $Organization['first_name'] : ' NA',
                'last_name'         => (!empty($Organization['last_name']))? $Organization['last_name'] : ' NA',
                'linkedin'          => $Organization['linkedin'],
                'email'             => $Organization['email'],
                'phone'             => $Organization['phone'],
                'description'       => $Organization['description'],
                'website'           => $Organization['website'],
                'tags'              => (!empty($Organization['verticals'])) ? explode(', ', $Organization['verticals']) : [],
                'custom_fields'     => ['Upvotes' => $up,'Downvotes' => $down, 'Tiresiasreviews' => $tiresiasReviews, 'Joyancereview' => $joyanceReview, 'Totalreviews' => $totalReviews],
                'status'            => 'Tiresias',
                'source'            => 'Tiresias'
            ];
            $leads = $this->Basecrm->createOrganization($comapnyDetail);
            
            if(isset($leads['error'])) {
                $errors          = json_encode(array('id' => $Organization['id'], 'error' => $leads['error']));
                $logs            = $this->Logs->newEntity();
                $logs->type      = 'BaseCrm Create Organization';
                $logs->errorcode = $leads['error'];
                $logs->type_id   = $Organization['companyid'];
                $logs->created   = date('Y-m-d H:i:s');
                $logs->modified  = date('Y-m-d H:i:s');
                $this->Logs->save($logs);
            } else {
                $cmmt = '';
                foreach ($Organization['all_comments'] as $Org) {
                    $cmmt = ucwords($Org['user']['name']).' Said at '.date('l M Y')." -- ".ucwords($Org['comment']);
                    $data = [];
                    $data['resource_id'] = $leads['id'];
                    $data['resource_type'] = 'lead';
                    $data['content'] = $cmmt;
                    $this->Basecrm->addNotes($data);
                }
            }
        }           
    }

   public function cronRun()
    {
       try{
            ini_set('max_execution_time', 0);
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            $this->viewBuilder()->layout(false);
            $this->autoRender = false;
            $this->loadModel('CronsCategories');
            $this->loadModel('CronSettings');
            $day = date('l');
            $CronSettings = $this->CronSettings->find('list', ['keyField' => 'id', 'valueField' => 'service_type'])->where(['week_day'=> $day ])->hydrate(false)->toArray();
            $CronsCategories = $this->CronsCategories->find('list', ['keyField' => 'cron_type', 'valueField' => 'data'])->hydrate(false)->toArray();
            $categories = array();
            if(isset($CronsCategories['category'])){
                $this->loadModel('Categories');
                $categoriesIds  = json_decode($CronsCategories['category'], true);
                $categories     =  $this->Categories->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['id in' => $categoriesIds])->hydrate(false)->toArray();
            }
            foreach($CronSettings as $CronSetting)
            {
                if( $CronSetting == 'ProductHunt')
                {
                    
                    $this->getProductHunt();
                }
            
                    
               /* if( $CronSetting == 'Pitchbook')
                {
                    $CronsCategories = $this->CronsCategories->find('list',['keyField' => 'cron_type', 'valueField' => 'data'])->hydrate(false)->toArray();
                    $verticals = array();
                    if(isset($CronsCategories['vertical']) && !empty($CronsCategories['vertical'])) {
                        $this->loadModel('Verticals');
                        $verticalIds = json_decode($CronsCategories['vertical'], true);
                        $verticals =  $this->Verticals->find('list',['keyField' => 'id', 'valueField' => 'code'])->where(['id in' => $verticalIds])->hydrate(false)->toArray();
                    }
                    $this->searchCompaniesPitchbook(1, $verticals);
                }  else*/ 
                else if( $CronSetting == 'BaseCRM') {
                    $previous_week  = strtotime("-1 week +2 day");
                    $start_week     = strtotime("last monday midnight",$previous_week);
                    $end_week       = strtotime("next sunday",$start_week);
                    $start_week     = date("Y-m-d",$start_week);
                    $end_week       = date("Y-m-d",$end_week);
                    $lastWeekOrg    = array();
                    
                    /****** Get Organisations ids which had voted last week ******/
                    $this->loadModel('OrganizationsReviews');
                    $organisationsWithReview = $this->OrganizationsReviews->find('list',['keyField' => 'organization_id','valueField' => 'organization_id'])->where(['date(`created`) >=' => $start_week, 'date(`created`) <=' => $end_week])->hydrate(false)->toArray();
                    /****** Get Organisations ids which had voted last week ******/

                    /****** Get Organisations ids which have comments from last week ******/
                    $this->loadModel('OrganizationsComments');
                    $organisationsWithcomments = $this->OrganizationsComments->find('list',['keyField' => 'organization_id','valueField' => 'organization_id'])->where(['date(`created`) >=' => $start_week, 'date(`created`) <=' => $end_week])->hydrate(false)->toArray();
                    /****** Get Organisations ids which have comments from last week ******/

                    $lastWeekOrg = array();
                    if(!empty($organisationsWithReview) && !empty($organisationsWithcomments)){
                        $lastWeekOrg = array_unique(array_merge($organisationsWithcomments, $organisationsWithReview));
                    } else if(empty($organisationsWithReview) && !empty($organisationsWithcomments)){
                        $lastWeekOrg = array_unique($organisationsWithcomments);
                    } else if(!empty($organisationsWithReview) && empty($organisationsWithcomments)){
                        $lastWeekOrg = array_unique($organisationsWithReview);
                    }
                    /**************Pass leads ids which has commented and votted last week *************/
                    if(!empty($lastWeekOrg)) {
                        $this->basecrmCreateOrganizaton($lastWeekOrg);
                    }
                    /**************Pass leads ids which has commented and votted last week *************/
                    /************** Updates commented and votted lead only*************/
                    $this->Organizations->updateAll(['status' => 2], ['id in' => $lastWeekOrg ]);
                    /************** Updates commented and votted lead only*************/
                }
            }
            $this->chruchbaseOrganizatons($categories);
       }       
       catch(Exception $e) {
             echo $organisations['error'] = 'Message: ' .$e->getMessage();
            // $this->redirect(['controller'=>'error','action'=>'index']);
        }       
    }

    public function categorySearch(){
      if($this->request->is('ajax'))
      {
        $this->viewBuilder()->layout(false);
        $this->autoRender = false;
        $category = $this->Categories->find('list',['keyField' => 'id','valueField' => 'name'])->where(['status' => 0,'name like' => '%'.$this->request->data['keyword'].'%'])->order(['name' => 'ASC'])->hyDrate(false)->toArray();
        if(!empty($category)){
            echo json_encode(array('status' => 1, 'data' => $category));
        } else {
            echo json_encode(array('status' => 0, 'data' => $category));
        }
      }
      die;
    }


    public function reconcile(){
        if($this->request->is('ajax'))
        {
            $this->viewBuilder()->layout(false);
            $reconcileOrg = $this->Organizations->find()->where(['id in' => [$this->request->data['id1'],$this->request->data['id2'] ] ])->hyDrate(false)->toArray();
            $this->set('reconcileOrg', $reconcileOrg);
        }
    }

    public function reconcileSave(){
        if($this->request->is('ajax'))
        {
            $this->viewBuilder()->layout(false);
            $this->autoRender = false;
        
            $organizationsEntity = $this->Organizations->newEntity($this->request->data);
            if($this->Organizations->save($organizationsEntity)){
                if(isset($this->request->data['delete_id'])){
                    $deletEnt = $this->Organizations->get($this->request->data['delete_id']);
                    $this->Organizations->delete($deletEnt);
                }
                $reconcileExist = $this->Organizations->find()->select(['id'])->where(['formal_company_name' => $this->request->data['formal_company_name']])->hyDrate(false)->toArray();
                $ishave = 0;
                $id1 = 0;
                $id2 = 0;
                if(count($reconcileExist) > 1){
                    $ishave = 1;
                    $id1 = $reconcileExist[0]['id'];
                    $id2 = $reconcileExist[1]['id'];
                }
                echo json_encode(array('status' => 1,'count' => count($reconcileExist),'reconcile' => $ishave,'id1' => $id1,'id2' => $id2));

            } else {
                echo json_encode(array('status' => 0));
            }
        }
    }

    public function processedLeads()
    {

    }

    public function getupdateFundedOrganizations() {                
        $this->autoRender   = false;
        $this->viewBuilder()->layout(false);
        $dealDate           = strtotime('-7 days');
        $announced_on       =  strtotime('-3 month');
        $options            = ['updated_since' => $dealDate,'page' => 1];        
        $funds              =  $this->Crunchbase->getAllFundRound($options);
        $org_to_update      = [];
       
        
        if(isset( $funds['data']['items'] ) &&  !empty( $funds['data']['items'] ))
        {
            $numberofpages =  $funds['data']['paging']['number_of_pages'];
            /*processing all the pages*/
            for ($i=1; $i <= $numberofpages;  $i++) {
                $chunk_options  = ['updated_since' => $dealDate,'page' => $i];        
                $chunk_funds    =  $this->Crunchbase->getAllFundRound($chunk_options);
               
                if( isset($chunk_funds['data']['items']) && !empty($chunk_funds['data']['items']) ) {
                    foreach($chunk_funds['data']['items'] as $fund) {
                  /* angle fundee only and announced date from last one month only */
                        if( ($fund['properties']['funding_type']=='angel') && (strtotime($fund['properties']['announced_on']) >= $announced_on) ) {                            
                            $funded_organisation =  $this->Crunchbase->getFundedEntity($fund['uuid']);
                            
                            if( isset($funded_organisation['data']) && !empty($funded_organisation['data']['item']) ) {                                
                                /*update recently refund status to 1 if we have that organisation */    
                                if($this->Organizations->exists(["companyid" => $funded_organisation['data']['item']['uuid'], "source" => 'crunchbase']))   {                                                                   
                                    $org_to_update[] = $funded_organisation['data']['item']['uuid'];                                    
                                }
                            }
                        }
                    }
                }
            }
        }        
        if( count($org_to_update)>0 ) {
            /*updating organization status*/
            $this->Organizations->updateAll(['recently_funded' => 1],['companyid in' => $org_to_update ]);            
        }
        
       //$this->updatechruchbaseOrganizatons();
    }
    
    
 /*
  * function to export record in excel file
  */
    function exportInExcel($fileName, $headerRow, $data) {
        ini_set('max_execution_time', 1600); //increase max_execution_time to 10 min if data set is very large
        $fileContent = implode("\t ", $headerRow)."\n";
        foreach($data as $result) {
        $fileContent .=  implode("\t ", $result)."\n";
        }
        header('Content-type: application/ms-excel'); /// you can set csv format
        header('Content-Disposition: attachment; filename='.$fileName);
        echo $fileContent;
        exit;
    }
    /*
     * SELECT a . * , b.review, u.name,u.username,c.comment FROM  organizations_reviews b  LEFT JOIN  `organizations` a ON b.organization_id = a.id
        LEFT JOIN organizations_comments c ON b.organization_id=c.organization_id  LEFT JOIN users u ON u.id = b.user_id WHERE 1 AND YEARWEEK( a.created ) = ( YEARWEEK( CURDATE( ) ) -1 )
        LIMIT 0 , 30'
     */
    
    public function getCommentFromOrganisation($org_id,$user_id){
         $this->loadModel('OrganizationsComments');
         $getComment = $this->OrganizationsComments->find('all')->where(['organization_id'=>$org_id,'user_id'=>$user_id])->hydrate(false)->first();
            if(!empty($getComment)){
                return $getComment['comment'];
            } 
            else {
                return false;
            }
           
         }
    
    public function export(){
                 //*************************code for xls ******************************************//
        require_once(ROOT . '/vendor' . DS  . 'PHPExcel' . DS  . 'Classes' . DS . 'PHPExcel.php');
        require_once(ROOT . '/vendor' . DS  . 'PHPExcel' . DS  . 'Classes' . DS .'PHPExcel'.DS. 'IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 12,
            ));

     
        $objPHPExcel->getActiveSheet()->getStyle('A1:AC2')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()
        ->getStyle('A1:AC2')
        ->getAlignment()
        ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:AA1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Leads - Listing');


        $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Company Name');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'First Name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Last Name');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'City');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'State');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'Country');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'Category');
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'Source');
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'Review');
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'Created');
        $objPHPExcel->getActiveSheet()->setCellValue('K2', 'Review By');
        $objPHPExcel->getActiveSheet()->setCellValue('L2', 'Comment');
        
       
        //$fileName = "organisationreport_".date("d-m-y:h:s").".xls";
        $conn = ConnectionManager::get('default');
        $stmt = $conn->execute('SELECT b.review, a . * , u.name,u.id as user_id
FROM organizations_reviews b
INNER JOIN organizations a ON b.organization_id = a.id
LEFT JOIN users u ON u.id = b.user_id
WHERE 1
AND YEARWEEK( a.created ) = ( YEARWEEK( CURDATE( ) ) -1 ) ORDER BY a.formal_company_name  ');
        $results = $stmt->fetchAll('assoc');
        $headerRow = array("Company Name", "First Name", "Last Name","City","State","Country","Category","Source","Review","Created","Review By","Comment");
        $lastWeek=array();
        
         $count = 3;
        foreach($results as $cen){
               $comment_organisation_user=  $this->getCommentFromOrganisation($cen['id'],$cen['user_id']);
                if($cen['review']==1) {
                    $vote="Up";
                }
                else if($cen['review']==NUll){
                    $vote="No Vote";
                }

                else {
                    $vote="Down";
                }
               $created_date =  date("Y-m-d",strtotime($cen['created']));
                $objPHPExcel->getActiveSheet()->getRowDimension($count)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$count, ((isset($cen['formal_company_name']) && ($cen['formal_company_name'] != '')) ?$cen['formal_company_name'] : '--' ));
                $objPHPExcel->getActiveSheet()->getRowDimension($count)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$count, ((isset($cen['formal_company_name']) && ($cen['formal_company_name'] != '')) ?$cen['formal_company_name'] : '--' ));
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$count, ((isset($cen['first_name']) && ($cen['first_name'] != '')) ?$cen['first_name'] : '--' ));
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$count, ((isset($cen['last_name']) && ($cen['last_name'] != '')) ?$cen['last_name'] : '--' ));
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$count, ((isset($cen['city']) && ($cen['city'] != '')) ?$cen['city'] : '--' ));
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$count, ((isset($cen['state']) && ($cen['state'] != '')) ?$cen['state'] : '--' ));
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$count, ((isset($cen['country']) && ($cen['country'] != '')) ?$cen['country'] : '--' ));
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$count, ((isset($cen['category']) && ($cen['category'] != '')) ?$cen['category'] : '--' ));
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$count, ((isset($cen['source']) && ($cen['source'] != '')) ?$cen['source'] : '--' ));
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$count, ((isset($vote) && ($vote != '')) ?$vote : '--' ));
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$count, ((isset($created_date) && ($created_date != '')) ?$created_date : '--' ));
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$count, ((isset($cen['name']) && ($cen['name'] != '')) ?$cen['name'] : '--' ));
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$count, ((isset($comment_organisation_user) && ($comment_organisation_user != '')) ?$comment_organisation_user : '--' ));
                
           
            
              /*$lastWeek[$count][]=str_replace(',', '', $value['formal_company_name']);
               $lastWeek[$count][]=str_replace(',', '', $value['first_name']);
               $lastWeek[$count][]=str_replace(',', '', $value['last_name']);
               $lastWeek[$count][]=str_replace(',', '', $value['city']);
               $lastWeek[$count][]=str_replace(',', '', $value['state']);
               $lastWeek[$count][]=str_replace(',', '', $value['country']);
               $lastWeek[$count][]=str_replace(',', '', $value['category']);
               $lastWeek[$count][]=str_replace(',', '', $value['source']);
               
              
                $lastWeek[$count][]=date("Y-m-d",strtotime($value['created']));
                $lastWeek[$count][]=$value['name'];
                $lastWeek[$count][]=str_replace(',', '', $comment_organisation_user);*/
            $count++;
           
        }
         // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Leads');
        
        
        $file = "exportleads.xls";
       
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
      
       


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$file);
        header('Cache-Control: max-age=0');
        //ob_end_clean();
        $objWriter->save('php://output');
        
        die; 
        
        
//        $this->exportInExcel($fileName, $headerRow, $lastWeek);
  }
    public function importOld(){
        
      $this->loadModel('Logs');
        
      require_once(ROOT . '/vendor' . DS  . 'PHPExcel' . DS  . 'Classes' . DS . 'PHPExcel.php');
      
     
      
      require_once(ROOT . '/vendor' . DS  . 'PHPExcel' . DS  . 'Classes' . DS .'PHPExcel'.DS. 'IOFactory.php');
      $objPHPExcel = \PHPExcel_IOFactory::load("example.xlsx");
        pr($objPHPExcel);die;
//echo ROOT . DS .'vendor';
        $inputfilename = 'demo.xls'; 
        $exceldata = array();
        try
        {
            $inputfiletype = \PHPExcel_IOFactory::identify($inputfilename);
            $objReader = \PHPExcel_IOFactory::createReader($inputfiletype);
            $objPHPExcel = $objReader->load($inputfilename);
        }
        catch(Exception $e)
        {
            die('Error loading file "'.pathinfo($inputfilename,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
        //  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
    for ($row = 2; $row <= $highestRow; $row++)
    { 

            
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                        
                        if(!$this->Organizations->exists(["companyid" => $rowData[0][0], "source" => 'pitchbook'] ))
                        {
                        $organisations = $this->Organizations->newEntity();
                        $organisations->companyid = $rowData[0][0];
                        $organisations->formal_company_name = $rowData[0][1];
                        if(!empty($rowData[0][4])){
                            $organisations->pbId = $rowData[0][4];
                        }
                        $organisations->description = $rowData[0][5];
                        $organisations->email = $rowData[0][33];
                        $organisations->city = $rowData[0][38];
                        $organisations->state = $rowData[0][39];
                        $organisations->country = $rowData[0][41];
                        $organisations->first_name = $rowData[0][31];
                        $organisations->website =$rowData[0][16];
                        $organisations->source = 'pitchbook';
                        $this->Organizations->save($organisations);
                        }
                       
                    



    }
    
    die("record import succesfully");
        

        
        /*try {
           $objPHPExcel = \PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
           die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        pr($allDataInSheet);die;
      $arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
            pr($arrayCount);die;*/
        
  }
  
 public function import(){
     require_once(ROOT .DS. 'vendor' . DS . 'SimpleXlsx' . DS . 'SimpleXlsx.php');
     $this->loadModel('Logs');
    if(!empty($_FILES["file"]["name"])){
          $uploadFilePath=WWW_ROOT . 'import/'.$_FILES['file']['name'];
          move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
          $inputfilename = $uploadFilePath; 
          
          if ($xlsx = SimpleXLSX::parse($uploadFilePath)) {
          $count=1;
          foreach($xlsx->rows() as $rowData){
            if($count <= 7){
                $count++;
               continue;
            }
            if(!empty($rowData[1]) && (!$this->Organizations->exists(["formal_company_name" => $rowData[1] ]) ) )
            {
                if($count > 7){
                    $organisations = $this->Organizations->newEntity();
                    $organisations->companyid = $rowData[0];
                    $organisations->formal_company_name = $rowData[1];
                    $organisations->legal_company_name = $rowData[3];
                    $organisations->pbId = $rowData[4];
                    $organisations->description =$rowData[5];
                    $organisations->category =$rowData[7];
                    $organisations->website = $rowData[17];
                    $name = explode(' ', $rowData[32]);
                    $organisations->first_name = $name[0];
                    $organisations->last_name = isset($name[1])? $name[1] : '';

                    $organisations->city = $rowData[39];
                    $organisations->state =$rowData[40]. ', '.$rowData[41];
                    $organisations->country =$rowData[42];
                    $organisations->phone = $rowData[43];                    
                    $organisations->address = $rowData[37];                    
                    $organisations->email = $rowData[45];                    
                    if(strpos(strtolower($rowData[77]),'seed') !== false){
                        $organisations->funding_type = 'seed';
                    } else if(strpos(strtolower($rowData[77]),'angel') !== false){
                        $organisations->funding_type = 'angel';
                    } else if(strpos(strtolower($rowData[77]),'convertible') !== false){
                        $organisations->funding_type = 'convertible_note';
                    } else if(strpos(strtolower($rowData[77]),'grant')!== false){
                        $organisations->funding_type = 'grant';
                    } else if(strpos(strtolower($rowData[77]),'coin') !== false){
                        $organisations->funding_type = 'initial_coin_offering';
                    } else if(strpos(strtolower($rowData[77]),'private') !== false){
                        $organisations->funding_type = 'private_equity';
                    } else if(strpos(strtolower($rowData[77]),'crowdfunding') !== false){
                        $organisations->funding_type = 'product_crowdfunding';
                    } else if(strpos(strtolower($rowData[77]),'undisclosed') !== false){
                        $organisations->funding_type = 'undisclosed';
                    } else if(strpos(strtolower($rowData[77]),'venture') !== false){
                        $organisations->funding_type = 'venture';
                    }
                    $organisations->source = 'pitchbook';
                    $this->Organizations->save($organisations);
                }
            }
              else {
               // $message = "Leads not imported";
             }

              $count++;
          }
          $message = "Leads imported successfully";
          $this->Flash->custom_success(__($message));
          $this->redirect(['controller'=>'organizations','action'=>'import-upload']);
      } else {
          //echo $this->Xlsx->parse_error();
           $message = "There is some error";
           $this->Flash->custom_success(__($message));
           $this->redirect(['controller'=>'organizations','action'=>'import-upload']);
       }
    } else {
        $message = "Please choose any file.";
            $this->Flash->custom_success(__($message));
            $this->redirect(['controller'=>'organizations','action'=>'import-upload']);
    }
}



public function importManualLeads(){
    require_once(ROOT .DS. 'vendor' . DS . 'SimpleXlsx' . DS . 'SimpleXlsx.php');
     $this->loadModel('Logs');
    if(!empty($_FILES["file"]["name"])){
          $uploadFilePath=WWW_ROOT . 'import/'.$_FILES['file']['name'];
          move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
          $inputfilename = $uploadFilePath; 
          
          if ($xlsx = SimpleXLSX::parse($uploadFilePath)) {
          $count=1;
          foreach($xlsx->rows() as $rowData){              
            if(!empty($rowData[0]) && (!$this->Organizations->exists(["formal_company_name" => $rowData[0]])))
                          {
                      
                              if($count>1){
                                $organisations = $this->Organizations->newEntity();
                                $organisations->formal_company_name = $rowData[0];
                                $organisations->legal_company_name = $rowData[1];
                                $organisations->website = $rowData[2];
                                $organisations->first_name = $rowData[3];
                                $organisations->last_name = $rowData[4];
                                $organisations->email = $rowData[5];
                                $organisations->linkedin = $rowData[6];
                                $organisations->phone = $rowData[7];
                                $organisations->city = $rowData[8];
                                $organisations->state =$rowData[9];
                                $organisations->country =$rowData[10];
                                $organisations->category =$rowData[11];
                                $organisations->description =$rowData[12];
                                $organisations->source = 'manual';
                                $this->Organizations->save($organisations);

                              }
                              $message = "Leads imported successfully";
                          }
                          else {
                            $message = "Leads not imported";
                         }

              $count++;
          }

      
     $this->Flash->custom_success(__($message));
     $this->redirect(['controller'=>'organizations','action'=>'import-manual']);
      
      
    } else {
          //echo $this->Xlsx->parse_error();
           $message = "There is some error";
           $this->Flash->custom_success(__($message));
           $this->redirect(['controller'=>'organizations','action'=>'import-manual']);
    }

    }
    else {

            $message = "Please choose any file.";
            $this->Flash->custom_success(__($message));
            $this->redirect(['controller'=>'organizations','action'=>'import-manual']);
    }



    }

    
/*    public function importManualLeads(){
    require_once(ROOT .DS. 'vendor' . DS . 'SimpleXlsx' . DS . 'SimpleXlsx.php');
     $this->loadModel('Logs');
    if(!empty($_FILES["file"]["name"])){
          $uploadFilePath=WWW_ROOT . 'import/'.$_FILES['file']['name'];
          move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
          $inputfilename = $uploadFilePath; 
          
          if ($xlsx = SimpleXLSX::parse($uploadFilePath)) {
          $count=1;
          foreach($xlsx->rows() as $rowData){
               
           
          if(!empty($rowData[0]) && (!$this->Organizations->exists(["formal_company_name" => $rowData[0]])))
                          {
                      
                              if($count>1){
                                $organisations = $this->Organizations->newEntity();
                                $organisations->formal_company_name = $rowData[0];
                                $organisations->legal_company_name = $rowData[1];
                                $organisations->website = $rowData[2];
                                $organisations->first_name = $rowData[3];
                                $organisations->last_name = $rowData[4];
                                $organisations->email = $rowData[5];
                                $organisations->linkedin = $rowData[6];
                                $organisations->phone = $rowData[7];
                                $organisations->city = $rowData[8];
                                $organisations->state =$rowData[9];
                                $organisations->country =$rowData[10];
                                $organisations->category =$rowData[11];
                                $organisations->description =$rowData[12];
                                $organisations->source = 'manual';
                                $this->Organizations->save($organisations);

                              }
                              $message = "Leads imported successfully";
                          }
                          else {
                            $message = "Leads not imported";
                         }

              $count++;
          }

      
     $this->Flash->custom_success(__($message));
     $this->redirect(['controller'=>'organizations','action'=>'import-manual']);
      
      
    } else {
          //echo $this->Xlsx->parse_error();
           $message = "There is some error";
           $this->Flash->custom_success(__($message));
           $this->redirect(['controller'=>'organizations','action'=>'import-manual']);
    }

    }
    else {

            $message = "Please choose any file.";
            $this->Flash->custom_success(__($message));
            $this->redirect(['controller'=>'organizations','action'=>'import-manual']);
    }



    }*/
    
    

  public function import_live_old(){
      
      
    $this->loadModel('Logs');
    require_once(ROOT . '/vendor' . DS  . 'PHPExcel' . DS  . 'Classes' . DS . 'PHPExcel.php');
    require_once(ROOT . '/vendor' . DS  . 'PHPExcel' . DS  . 'Classes' . DS .'PHPExcel'.DS. 'IOFactory.php');
   $mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet'];
    if(in_array($_FILES["file"]["type"],$mimes)){
        
        
        
        $uploadFilePath=WWW_ROOT . 'import/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
        $inputfilename = $uploadFilePath; 
      $exceldata = array();
      try
      {
          
          $inputfiletype = \PHPExcel_IOFactory::identify($inputfilename);
          $objReader = \PHPExcel_IOFactory::createReader($inputfiletype);
          $objPHPExcel = $objReader->load($inputfilename);
      }
      catch(Exception $e)
      {
          die('Error loading file "'.pathinfo($inputfilename,PATHINFO_BASENAME).'": '.$e->getMessage());
      }
      //  Get worksheet dimensions
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();

    //  Loop through each row of the worksheet in turn
    for ($row = 2; $row <= $highestRow; $row++)
    { 


                      //  Read a row of data into an array
                      $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                      if(!$this->Organizations->exists(["companyid" => $rowData[0][0], "source" => 'pitchbook'] ))
                      {
                      $organisations = $this->Organizations->newEntity();
                      $organisations->companyid = $rowData[0][0];
                      $organisations->formal_company_name = $rowData[0][1];
                      if(!empty($rowData[0][4])){
                          $organisations->pbId = $rowData[0][4];
                      }
                      $organisations->description = $rowData[0][5];
                      $organisations->email = $rowData[0][33];
                      $organisations->city = $rowData[0][38];
                      $organisations->state = $rowData[0][39];
                      $organisations->country = $rowData[0][41];
                      $organisations->first_name = $rowData[0][31];
                      $organisations->website =$rowData[0][16];
                      $organisations->source = 'pitchbook';
                      $this->Organizations->save($organisations);
                      }





    }

    $message = "Leads imported successfully";
    $this->Flash->custom_success(__($message));
    $this->redirect(['controller'=>'organizations','action'=>'import-upload']);
    

    }
    else {
       
            $message = "Sorry, File type is not allowed. Only Excel file.";
            $this->Flash->custom_success(__($message));
            $this->redirect(['controller'=>'organizations','action'=>'import-upload']);
    }
        
   
        
  }
  public function importUpload(){
      
  }
  public function importManual(){
      
  }
  
  /*
   * function to load more news
   */







  /*
     * end of all function for  
  */

    public function delete($id = null){
    $this->viewBuilder( )->layout( false );
    $this->autoRender = false;
    if($id != null){

        $deletEnt = $this->Organizations->get($id);
        if($this->Organizations->delete($deletEnt)){
            echo json_encode(array('status' => 1));
        } else {
            echo  json_encode(array('status' => 0));
        }
    }   
  }



  /* download excel of not voting leads for last weak */
  public function createCSVtemp (){
       /* get leads of last week */
        $previous_week  = strtotime("-1 week +2 day");
        $start_week     = strtotime("last monday midnight",$previous_week);
        $end_week       = strtotime("next sunday",$start_week);
        $start_week     = date("Y-m-d",$start_week);
        $end_week       = date("Y-m-d",$end_week);
        $Organizations = $this->Organizations->find()->select(['id','formal_company_name','legal_company_name','website','first_name','last_name','email','linkedin','phone','city','state','country','api_url','category','description','created'])->contain(['AllReviews' => function($q){
            return $q->select(['organization_id']);
        },'AllComments' => function($q){
            return $q->select(['organization_id']);
        }])->where(['date(created) >=' => $start_week, 'date(created) <=' => $end_week])->hydrate(false)->toArray();
        $data = array();
        foreach ($Organizations as $key => $Organization) {
            if(empty($Organization['all_comments']) && empty($Organization['all_reviews'])){
                $data1 = array();
                $data1[]  = $Organization['formal_company_name'];         
                $data1[]  = $Organization['legal_company_name'];         
                $data1[]  = $Organization['website'];         
                $data1[]  = $Organization['first_name'];         
                $data1[]  = $Organization['last_name'];         
                $data1[]  = $Organization['email'];         
                $data1[]  = $Organization['linkedin'];         
                $data1[]  = $Organization['phone'];         
                $data1[]  = $Organization['city'];         
                $data1[]  = $Organization['state'];         
                $data1[]  = $Organization['country'];         
                $data1[]  = $Organization['api_url'];         
                $data1[]  = $Organization['category'];         
                $data1[]  = $Organization['description'];         
                $data[] = $data1;
            }
        }
        /* get leads of last week */

        $headerRow = array('Company Name','Legal  Name','Website','First Name', 'Last Name','Email','Linkedin','Phone','City','State','Country','Source Link','Category','Description');

        require_once(ROOT . '/vendor' . DS  . 'PHPExcel' . DS  . 'Classes' . DS . 'PHPExcel.php');
        require_once(ROOT . '/vendor' . DS  . 'PHPExcel' . DS  . 'Classes' . DS .'PHPExcel'.DS. 'IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        /* set header of shhet */
        $field = 'A';        
        foreach ($headerRow as $key1 => $value1) {
            $objPHPExcel->getActiveSheet()->setCellValue($field.'1', $value1);                
            $field++; 
        }         
       
        /* set header of shhet */

        
        $count = 2;
        foreach ($data as $key => $value) {
            $field = 'A';
            foreach ($headerRow as $key1 => $value1) {
                $objPHPExcel->getActiveSheet()->setCellValue($field.$count, $value[$key1]);                
                $field++; 
            }   
            $count++;
        }
         $objPHPExcel->getActiveSheet()->setTitle('Leads');       
        
        $file = "notVotedLeads.xlsx";       
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();          
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$file);
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        die; 
  }


  public function cleanOrganisationsTable(){
    $this->autoRender = false;
    $this->viewBuilder()->layout(false);
    try {
        /*************** Create EXCEL for last month records *********/
        require_once(ROOT . '/vendor' . DS  . 'PHPExcel' . DS  . 'Classes' . DS . 'PHPExcel.php');
        require_once(ROOT . '/vendor' . DS  . 'PHPExcel' . DS  . 'Classes' . DS .'PHPExcel'.DS. 'IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->setTitle('Leads');
        $objPHPExcel->setActiveSheetIndex(0);
        $styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 12));
        $objPHPExcel->getActiveSheet()->getStyle('A1:AI1')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AI1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $headers = array('id','company ID','pb ID','Company Name','Legal Company Name','First Name','Last Name','Linkedin','Email','Phone','Founded On','Image','Description','City','State','Country','Person ID','Website','Category','Source','verticals','Status','Created','Recently Funded','Web Path','API URL','Stock Exchange','Stock Symbol','Permalink','Address','Funding Type','Money Raised','Announced on','Updated Since','Total Funding');
        $coulum ='A' ;
        foreach ($headers as $headerKey => $header) {
            $coulumIndex = $headerKey+1;
            $objPHPExcel->getActiveSheet()->setCellValue($coulum.'1', $header);
            $coulum++;
        }
        /************* Get previous month leads ***************/
        $lastMonthStart =  date('Y-m-d', strtotime('first day of last month'));        
        $lastMonthEnd =  date('Y-m-d', strtotime('last day of last month'));        
        $lastMonthLeads = $this->Organizations->find()->where(['created >=' => $lastMonthStart, 'created <=' => $lastMonthEnd ])->hyDrate(false)->toArray();
        $count = 2;        
        foreach ($lastMonthLeads as $lastMonthLead) {
            $coulum ='A' ;
            $objPHPExcel->getActiveSheet()->getRowDimension($count)->setRowHeight(30);
            foreach ($lastMonthLead as $key => $leadData) {
                $objPHPExcel->getActiveSheet()->setCellValue($coulum.$count, ((!empty($leadData))? $leadData : 'N/A') );
                $coulum++;
            }
            $count++;
        }      
        /************* Get previous month leads ***************/
        $file = strtotime($lastMonthStart)."-".date('YmdHis')."-leads.xls";
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();        
        $objWriter->save(WWW_ROOT.'leads/'.$file);
        /*************** Create EXCEL for last month records *********/

        /*************** Send Email to Admin **********/
               $from_email   = Configure::read('from_email');
               $project_name = Configure::read('project_name');
               $siteUrl = Configure::read('SITEURL').'leads/'.$file;
               $mailData = array('link' => $siteUrl,'date' => array('start' =>$lastMonthStart,'end' =>$lastMonthEnd )); 
               $email   = new Email();
               $email   = $email
                        ->viewVars($mailData)
                        ->template('leaddata')
                        ->emailFormat('html')
                        ->to($from_email)
                        ->bcc('shanney@teqmavens.com')
                        ->subject('Tiresias Lead Backups')
                        ->from([$from_email => $project_name]);
                        
                if($email->send()){
                    die('success');
                  //$this->Organizations->deleteAll(['created <=' => $lastMonthEnd]);
                }

        /*************** Send Email to Admin **********/
    } catch(Exception $e) {

    }
    
  }

}