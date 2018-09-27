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
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Mailer\Email;
use SimpleXlsx\SimpleXlsx;
use DatePeriod;
use DateTime;
use DateInterval;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController
{

    public function initialize()
    {
        $this->loadComponent('Basecrm');
        $this->loadComponent('Crunchbase');
        parent::initialize();
    }

    public function beforeFilter(Event $event){
        $this->loadModel('CronSettings');
        $this->loadModel('Categories');
        $this->loadModel('Organizations');
        $this->loadModel('Verticals');
        $this->loadModel('Countries');
        $this->loadModel('Filters');
        $this->loadModel('Logs');
        $this->Auth->allow(['forgotpassword','resetpassword','sendEmail','sendCustomEmail','sendCustomEmailHoney','transomRefreshList']);
        parent::beforeFilter($event);
    }


    /**
     * login function to show the login form of the application
     *
     * @param string ...$path Path segments.
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
  public function login()
    {
        $this->set('title', 'login');
        if ($this->Auth->user()) {
            $this->redirect("/organizations/index");
        }
        $this->viewBuilder()->setLayout('login');
        if($this->request->is('post')) {
            $user = $this->Auth->identify();
            if($user) {
              $this->loadModel('Users');
              $user = $this->Users->find()->select(['id','name','username','role','users_group_id'])->where(['Users.id' => $user['id']])->contain(['UsersGroups' => function($w){
                return $w->select(['id','name']);
              }])->hydrate(false)->first();
              $this->Auth->setUser($user);
            }else{
                $this->Flash->customError('Your username or password is incorrect.', ['key' => 'resendemail']);
            }
            return $this->redirect('/users/login');
        }
    }

    /**
     * Function to logout
     * Function to logout from the application
     *
     */
    public function logout(){
        $this->Flash->custom_success('You are now logged out.');
        $this->request->session()->destroy();
        return $this->redirect('/users/login');
    }

    /**
     * dashboard function to show the page after login with graphs and stats.
     *
     */
    public function dashboard(){
        $this->loadModel('OrganizationsReviews');
        $this->loadModel('ReadingList');
        $this->loadModel('OrganizationsComments');
        $this->loadModel('Theses');
        $startDate = date('Y-m-01',strtotime('this month'));
        $endDate = date('Y-m-t',strtotime('this month'));

        $organiation  = $this->Organizations->find('list',['keyField' => 'id','valueField' => 'source'])->where(['DATE(`created`) >=' => $startDate,'DATE(`created`) <=' => $endDate])->hydrate(false)->count();
        $organiationcomment  = $this->OrganizationsComments->find('list',['keyField' => 'id','valueField' => 'organization_id'])->where(['DATE(`created`) >=' => $startDate,'DATE(`created`) <=' => $endDate,'user_id' => $this->Auth->user('id')])->hydrate(false)->toArray();

        $userReview  = $this->OrganizationsReviews->find()->select(['review','organization_id'])->where(['user_id' => $this->Auth->user('id'), 'DATE(`created`) >=' => $startDate,'DATE(`created`) <=' => $endDate])->hydrate(false)->toArray();

        $orgViewCm = array();
        $upVote = 0;
        $downVote = 0;
        if(!empty($userReview))
        {
            foreach ($userReview as $review) {
                $orgViewCm[] = $review['organization_id'];
                if($review['review'] == 0){
                    $downVote++;
                } else if($review['review'] == 1){
                    $upVote++;
                }
            }
        }
        $organiationCmt1 = array_unique(array_merge($organiationcomment,$orgViewCm));
        $organiationCmt = count($organiationCmt1);
        $this->loadModel('ReadingList');
        $ReadingList = $this->ReadingList->find()->contain(['Users' => function($q){
            return $q->select(['name']);
        }])->order(['ReadingList.id' => 'Desc'])->limit(4)->hydrate(false)->toArray();

        $theses = $this->Theses->find()->where(['status' => 1])->hydrate(false)->first();
        $this->set(compact('organiation','userReview','downVote','upVote','organiationCmt','sourceCount','ReadingList','theses'));
    }


    /**
     * settings function to show the settings page
     *
     */
    public function settings() {
       $cron_settings = $this->CronSettings->newEntity();
       $servicve_type = 'Pitchbook' ;
       if(!$this->request->is('ajax') && $this->request->is('post')){
              if(isset($this->request->data['submit_password_change']) && $this->request->data['submit_password_change'] == 'password_change'){
                $user = $this->Users->get($this->Auth->user('id'));
                $userData = $this->Users->patchEntity($user, $this->request->data);
                $errors = $userData->errors();
                if(count($errors) <= 0){
                    if($this->Users->save($userData)){
                        $message = "Password updated successfully";
                        $this->Flash->custom_success(__($message));
                    }else{
                        $message = "Something went wrong, please try again.";
                        $this->Flash->custom_error(__($message));
                    }

                } else {
                    $message = "Unable to Update: - ";
                    foreach($errors as $key=>$val){
                        if(array_key_exists('_empty', $val)){
                            $message .= $val['_empty'];
                        }elseif(array_key_exists('custom', $val)){
                            $message .= $val['custom'];
                        }
                        break;
                    }
                    $this->Flash->custom_error(__($message));
                }
            } else if(isset($this->request->data['submit_cron_settings'])) {
                $isExist = $this->CronSettings->exists(['service_type' => $this->request->data['service_type'] ]);
                $this->request->data['modified'] = date('Y-m-d H:i:s');
                if(empty($isExist)) {
                    $this->request->data['created'] = date('Y-m-d H:i:s');
                    $cronEnt = $this->CronSettings->newEntity($this->request->data);
                    if($this->CronSettings->save($cronEnt)){
                     $message = "Cron settings updated successfully";
                        $this->Flash->custom_success(__($message));
                    }else{
                        $message = "Something went wrong, please try again.";
                        $this->Flash->custom_error(__($message));
                    }
                } else {
                    $cronEnt = $this->CronSettings->updateAll(['week_day' => $this->request->data['week_day'] , 'modified' => $this->request->data['modified']], ['service_type' => $this->request->data['service_type']]);
                    if($cronEnt){
                       $message = "Cron settings updated successfully";
                       $this->Flash->custom_success(__($message));
                    }
                }
            }
       } else if($this->request->is('ajax') && $this->request->is('post')) {
            $servicve_type =  $this->request->data['service_type'];
            $this->request->data = $this->CronSettings->find()->where(['service_type' => $this->request->data['service_type'] ])->hydrate(false)->first();
       }
       $this->set(compact('cron_settings','servicve_type'));
       if($this->request->is('ajax')) {
            $this->viewBuilder()->layout(false);
            $this->autoRender = false;
            $this->render('/Element/users/settings');
       }
    }
    
    
    
    public function addFilter(){
        
        
      

        $user_id =  $this->request->session()->read('Auth.Admin.id');       
        $message = 'filter added successfully';
        $getCountryList = $this->Countries->find('list',['keyField'=>'name','valueField'=>'name'])->group('name')->hydrate(false)->toArray();
        $getFilterCountry=$this->Filters->find('all')->where(['user_id'=>$user_id,'status'=>0])->group('filter_value')->hydrate(false)->toArray();
        $allreadyAppliedFilter = $this->Filters->find('all')->where(['user_id'=>$user_id,'status'=>1])->group('filter_value')->hydrate(false)->toArray();
         
        //$getCountryList['all']='All';
        
        if ($this->request->is('post')) {
            
           
            
           if($this->request->data('check_all')=='1' || $this->request->data('country')==''){
                $this->Filters->deleteAll([       
                        'Filters.status'=>'0',
                         
                     ]);
                      $data = [
                                            'filter_by' => 'country',
                                            'filter_value' => 'all',
                                            'user_id' => $user_id,
                                            'status' => 0
                                            
                                ];
                        $filtersCountryData = $this->Filters->newEntity($data);
                        
                        //$CourseTrainers = $this->Filters->patchEntity($filtersEntity, $data);
                        $this->Filters->save($filtersCountryData);
            }
            else if(!empty($this->request->data('country'))) {
           
            $countrylist = $this->request->data('country'); 
                
             if (is_array($countrylist)) {
                   $this->Filters->deleteAll([       
                        'Filters.status'=>'0',
                         
                     ]);
                    foreach ($countrylist as $countryData) {
                       
                            $data = [
                                'filter_by' => 'country',
                                'filter_value' => $countryData,
                                 'user_id' => $user_id
                               
                            ];
                     
                       
                       
                        $filtersCountryData = $this->Filters->newEntity($data);

                        //$CourseTrainers = $this->Filters->patchEntity($filtersEntity, $data);
                        $this->Filters->save($filtersCountryData);
                       
                    }
                    
                }
            }
           
             return $this->redirect("/users/add-filter");   
        }
      
        //$filtersData = $this->Filters->newEntity($this->request->data);
        //$errors = $filtersData->errors();
        //if ($save_data = $this->Filters->save($filtersData)) {
           // $this->Flash->custom_success(__($message));
            //return $this->redirect("/users/list-filter");
           
        //}
        $this->set(compact('getCountryList','getFilterCountry','allreadyAppliedFilter'));    
    }
    
    public function RemoveFilter(){
        if($this->request->data('id')){
            $removeId = $this->request->data('id');
            $this->Filters->updateAll(['status'=>2],['id'=>$removeId]);
            echo json_encode( array( 'status' => 1,'message'=>'removed'));
            
        }
        else {
             echo json_encode(array('status'=>0,'message'=>'error'));
        }
        exit();
    }
    
    
    public function addCountry(){
        
        $getCountryList=array();
        $getLocations = $this->Crunchbase->getLocationCountry();
        
        if(!empty($getLocations['data']['items'])){
         foreach($getLocations['data']['items'] as $countryList){
           $getCountryList[$countryList['properties']['country']] = $countryList['properties']['country'];
            $data = [
                                'name' => $countryList['properties']['country'],
                                
                               
                    ];
             $filtersCountryData = $this->Countries->newEntity($data);
              $this->Countries->save($filtersCountryData);
             
            
         }
        }
        die;
    }
    
    /*
     * function to add date
     */
     public function addDate(){
        $user_id =  $this->request->session()->read('Auth.Admin.id');
            
         $message = 'date  format added successfully';
         $getDate = $this->Users->find()->where( [ 'id' => $user_id ] )->hydrate( false )->first();
         
        //$getCountryList['all']='All';
        
        if ($this->request->is('post')) {
              $this->Users->updateAll(['date_format' => $this->request->data[ 'date_format' ]], ['id' => $user_id]);
                        
                      //$CourseTrainers = $this->Filters->patchEntity($filtersEntity, $data);
                
           
         
           
             return $this->redirect("/users/add-date");   
        }
      
        $this->set(compact('getDate')); 
         
    }

    /**
     * categories function to show the list of all categories.
     *
     */
    public function categories(){
        $verticals = $this->Verticals->find('list',['keyField' => 'id','valueField' => 'name'])->order(['name' =>'ASC'])->hydrate(false)->toArray();
        $conditions['status'] = 0;
        if($this->request->is('ajax') && isset($this->request->data['keyword']))
        {
            $conditions['name like'] = "%".$this->request->data['keyword']."%";
        }
        $categoriesQuery = $this->Categories->find('list',['keyField' => 'id','valueField' => 'name'])->where([$conditions])->hydrate(false);
        $this->paginate = ['limit' => 100,'order' => ['name' => 'ASC']];
        $categories = $this->paginate($categoriesQuery);
        $this->loadModel('cronsCategories');
        $cronSetting = $this->cronsCategories->find()->hydrate(false)->toArray();
        $this->set(compact('categories','verticals','cronSetting'));
        if($this->request->is('ajax'))
        {
          $this->viewBuilder()->layout(false);
          $this->render('/Element/users/categories');
        }
    }


    function deleteCategory($id = 0){
        $Categories = $this->Categories->get($id);
        if($this->Categories->delete($Categories)){
             $this->Flash->custom_success(__('Category has been deleted'));
            return $this->redirect("/users/categories");
        }
    }

    /**
     * addcategories function to add the new category.
     *
     */
    public function addcategory($id = 0){

        if ($this->request->is('post') || $this->request->is('put')) {
            if($id){
                    $message = 'Category updated successfully';
                    $this->request->data['id'] = $id;
                }else{
                    $message = 'Category added successfully';
                }

            $categoriesData = $this->Categories->newEntity($this->request->data);
            $errors = $categoriesData->errors();

            if (count($errors) <= 0) {


                if ($this->Categories->exists(array("name" => $this->request->data['name'])) && $this->request->is('post')) {
                    $message = 'Category Already Exists';
                } elseif ($save_data = $this->Categories->save($categoriesData)) {


                    $this->Flash->custom_success(__($message));
                    return $this->redirect("/users/categories");
                    die;
                } else {
                    $message = 'Error while saving';
                }
                $this->Flash->custom_error(__($message));
            }else{
                    $message = "Unable to Add: - ";

                    foreach($errors as $key=>$val){
                        $message .= $val['_empty'];
                        break;
                    }
                    $this->Flash->custom_error(__($message));
                }
        }

        if($id){
            $categories = $this->Categories->get($id);
        }else{
            $categories = $this->Categories;
        }
        $this->set(compact('categories'));
    }


    /*
    * Author: Hanney Sharma
    * Description: Create new record on baseCrm. need to create array in proper format as given
    * Url: https://developers.getbase.com/docs/rest/reference/leads
    * Return: Saved lead info array
    */

    public function basecrmCreateOrganizaton(){
        if($this->request->is('post')){
            $Organizations = $this->Organizations->find()->contain(['AllReviews' => function($q){
                return $q->select(['organization_id','review']);
            },'AllComments' =>  function($q){
                return $q->select(['organization_id','user_id','comment','created']);
            },'AllComments.Users' =>  function($q){
                return $q->select(['id','name']);
            }])->where(['id in' => $this->request->data['org']])->hydrate(false)->toArray();
            $errors = array();
            foreach ($Organizations as $key => $Organization) {
                $down = 0;
                $up = 0;
                foreach ($Organization['all_reviews'] as $key => $rev) {
                    if($rev['review'] == 0){
                        $down++;
                    } else {
                        $up++;
                    }
                }
               $comapnyDetail = [
                    'organization_name' => $Organization['formal_company_name'],
                    'address'=> ['country' => $Organization['country'],'state' => $Organization['state'],'city' => $Organization['city']],
                    'first_name' => $Organization['first_name'],
                    'last_name' => $Organization['last_name'],
                    'linkedin' => $Organization['linkedin'],
                    'email' => $Organization['email'],
                    'phone' => $Organization['phone'],
                    'description' => $Organization['description'],
                    'website' => $Organization['website'],
                    'tags' => (!empty($Organization['verticals'])) ? explode(', ', $Organization['verticals']) : [],
                    'custom_fields' => ['Vote Up' => $up,'Vote Down' =>$down]
                ];
                $leads = $this->Basecrm->createOrganization ($comapnyDetail);
                if(isset($leads['error'])) {
                    $errors = json_encode(array('id' =>$Organization['id'],'error' =>$leads['error']));
                    $logs = $this->Logs->newEntity();
                    $logs->type = 'BaseCrm Create Organization';
                    $logs->errorcode    = $leads['error'];
                    $logs->type_id      = $Organization['companyid'];
                    $logs->created      = date('Y-m-d H:i:s');
                    $logs->modified     = date('Y-m-d H:i:s');
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
            $this->Organizations->updateAll(['status' => 2],['id in' => $this->request->data['org'] ]);
        }
    }


    /*
    * Author: Hanney Sharma
    * Description: get all leads list. Need to pass search parameters $options
    * Url: https://developers.getbase.com/docs/rest/reference/leads (sort_by)
    * Return: array of leads list
    */

    public function basecrmGetAllOrganizaton(){
        $options = ['sort_by' => 'created_at:desc','per_page' => 5];
        $allLeads = $this->Basecrm->getAll($options);
        pr($allLeads);
        die;
    }

    /*
    * Author: Hanney Sharma
    * Description: get leads information by id.
    * Url: https://developers.getbase.com/docs/rest/reference/leads
    * Return: array of lead informaton
    */

    public function basecrmGetOrganizatonById(){
        $id = '1929721479';
        $allLeads = $this->Basecrm->getById($id);
        pr($allLeads);
        die;
    }

    /*
    * Author: Hanney Sharma
    * Description: Remove Organizaton from baseCrm.
    * Url: https://developers.getbase.com/docs/rest/reference/leads
    * Return: array of lead informaton
    */

    public function basecrmDeleteOrganizatonById(){
        $id = '1929722022';
        $leads = $this->Basecrm->deleteOrganizaton($id);
        pr($leads);
        die;
    }



    public function saveCronCategories(){
        if($this->request->is('ajax') && isset($this->request->data['ids']))
        {
            $this->viewBuilder()->layout(false);
            $this->autoRender = false;
            $this->loadModel('cronsCategories');
            $isexst = $this->cronsCategories->find()->select(['id','data'])->where(['cron_type' => $this->request->data['cron']])->hydrate(false)->first();
            if(!empty($isexst)){
                $data['id'] = $isexst['id'];
                $already = json_decode($isexst['data'], true);
                $this->request->data['ids'] = array_unique( array_merge($already,$this->request->data['ids']));
                $ids = $this->request->data['ids'];
                if(isset($this->request->data['remove']) && !empty($this->request->data['remove'])) {
                    foreach ($this->request->data['remove'] as  $rmv) {
                        $akey = array_search($rmv, $ids);
                        unset($ids[$akey]);
                    }
                }
                $this->request->data['ids'] = $ids;
            }
            $data['data'] = json_encode($this->request->data['ids']);
            $data['cron_type'] = $this->request->data['cron'];
            $data['created'] =date('Y-m-d H:i:s');
            $dataEntity = $this->cronsCategories->newEntity($data);
            if($this->cronsCategories->save($dataEntity))
            {
                echo json_encode(array('status' => 1));
            } else {
                echo json_encode(array('status' => 0));
            }

        }
    }

    public function clearAllCrons(){
        if($this->request->is('ajax') && isset($this->request->data['sec'])){
            $this->viewBuilder()->layout(false);
            $this->autoRender = false;
            $this->loadModel('cronsCategories');
            if($this->cronsCategories->deleteAll(['cron_type' => $this->request->data['sec']])){
                echo json_encode(array('status' => 1));
            } else {
                echo json_encode(array('status' => 1));
            }
        }
    }

    public function mapData()
    {
        //if($this->request->is('ajax')){
            $this->viewBuilder()->layout(false);
            $this->autoRender = false;
            $range = $this->createDateRange($this->request->data['start'], $this->request->data['end'], $format = "Y-m-d");
            
            $organisations = $this->Organizations->find()->select(['id','created','source'])->where(['DATE(`created`) >=' => $this->request->data['start'], 'DATE(`created`) <=' => $this->request->data['end']])->order(['created' => 'asc'])->hydrate(false)->toArray();
            if(empty($organisations)){
                echo json_encode(array('status' => 0));
            } else {
                $sortAccSource1 = array();
                foreach ($organisations as $key => $value) {
                    $date = date('Y-m-d',strtotime($value['created']));
                    $sortAccSource1[$date][$value['source']][$key] = $value['id'];
                }
                $sortAccSource = array();
                foreach ($range as $rng) {
                    if(isset($sortAccSource1[$rng])){
                        $sortAccSource[$rng] = $sortAccSource1[$rng];
                    }  else {
                        $sortAccSource[$rng] = array();
                    }
                }
                $crunchBook = array();
                $pitchBase = array();

                foreach($sortAccSource as $dateK => $value){
                    $pitchBase[] = array(date('Y',strtotime($dateK)),date('n',strtotime($dateK)),date('j',strtotime($dateK)),(isset($value['pitchbase']))? count($value['pitchbase']) : 1);
                    $crunchBook[] = array(date('Y',strtotime($dateK)),date('n',strtotime($dateK)),date('j',strtotime($dateK)),(isset($value['crunchbase']))? count($value['crunchbase']) : 1);
                }
                echo json_encode(array('status' => 1,'pitchbase' =>$pitchBase,'crunchBook' =>$crunchBook));
            }
        //}
    }

    public function addUser($id = null){
        $this->loadModel('Users');
        $userEnt = $this->Users->newEntity();
        if($this->request->is('post'))
        {
            if($id != null){
              $userEnt =  $this->Users->get($id);
              $message = "User Has Been Edit Successfully";
            } else {
              $message = "User Has Been Added Successfully";
            }
            $userdata = $this->Users->patchEntity($userEnt, $this->request->data);
            if($this->Users->save($userdata)){
                
                $this->Flash->custom_success(__($message));
                 return $this->redirect(['controller' => 'Users','action' => 'index']);
            }

        }
        if($id != null){
            $this->request->data = $this->Users->find()->where(['id' => $id])->hydrate(false)->first();
        }
        $this->loadModel('UsersGroups');
        $groups = $this->UsersGroups->find('list',[
            'keyField' => 'id',
            'valueField' => 'name'
          ])->hydrate(false)->toArray();
        $this->set(compact('userEnt','groups'));
    }

    public function index(){
        $this->loadModel('Users');
        $paginationCountChange = $this->pagelimit;
        $functionName = 'index';
        if($this->request->is('ajax')){
            if(isset($this->request->query['paginationCountChange'])){
                $paginationCountChange = $this->request->query('paginationCountChange');
            }
        }
        $query = $this->Users->find()->where(['role !=' => 1 ])->hydrate(false);
        $users = $this->paginate($query);
        $this->set(compact('paginationCountChange','users','functionName'));
        if($this->request->is('ajax')){
            $this->render('/Element/users/users');
        }
    }


    public function delete($id = null)
    {
        if($id != null){
           $this->loadModel('Users');
           $userEnt = $this->Users->get($id);
           if($this->Users->delete($userEnt)){
                $message = "User Has Been delete Successfully";
                $this->Flash->custom_success(__($message));
                return $this->redirect(['controller' => 'Users','action' => 'index']);
           }
        }
    }

    function businessIntelligence(){

    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function forgotpassword()
    {
        $this->viewBuilder()->layout('login');
        if($this->request->is('post')){

            $mailData     = [];
            $randomString = $this->generateRandomString(15);
            $emailTo      = $this->request->data['email'];
            $emailExists  = $this->Users->exists(['username'=>$emailTo]);
            $from_email   = Configure::read('from_email');
            $project_name = Configure::read('project_name');
            if($emailExists){

                $userdetail   = $this->Users->find()->where(['username'=>$emailTo])->hydrate(false)->first();

                $mailData['name'] = $userdetail['name'];
                $mailData['link'] = $randomString;
                $time_expire      = strtotime("+15 minutes",strtotime(date('Y-m-d H:i:s')));
                $token_expire     = date('Y-m-d H:i:s',$time_expire);

                $user = $this->Users->get($userdetail['id']);
                $userData = $this->Users->patchEntity($user, ['token'=>$randomString,'token_expire'=>$token_expire]);
                $errors = $userData->errors();

                if(count($errors) <= 0){
                    $this->Users->save($userData);
                }
                $email       = new Email();
                $email       = $email
                               ->viewVars($mailData)
                               ->template('forgetpassword', 'emaildefault')
                               ->emailFormat('html')->to($emailTo)
                               ->subject('Reset Password')
                               ->from([$from_email => $project_name]);

                if($email->send()){
                    $message = "Email has been Sent.";
                    $this->Flash->custom_success(__($message));
                    return $this->redirect(['controller' => 'Users','action' => 'login']);
                }else{
                    $message = "Something went wrong.please try again";
                    $this->Flash->custom_success(__($message));
                    return $this->redirect(['controller' => 'Users','action' => 'forgotpassword']);
                }

            }else{
                $message = "$email Does not Exists.";
                $this->Flash->custom_success(__($message));
                return $this->redirect(['controller' => 'Users','action' => 'login']);
            }
        }
        $this->set(['title'=>'Forgot Password']);
    }

    public function resetpassword($token=null){
        $this->viewBuilder()->layout('login');
        if(isset($token) && !empty($token)){

            $tokenExists = $this->Users->exists(['token'=>$token]);
            $userdetail  = $this->Users->find()->where(['token'=>$token])->hydrate(false)->first();

            $tokenValid  = strtotime(date('Y-m-d H:i:s')) < strtotime($userdetail['token_expire']) ? true : false;

            if(isset($tokenExists) && !empty($tokenExists) && $tokenValid ){

                if($this->request->is('post')){

                    $this->request->data['token'] = null;
                    $user      = $this->Users->get($userdetail['id']);
                    $userData  = $this->Users->patchEntity($user, $this->request->data);
                    $errors    = $userData->errors();

                    if(count($errors) <= 0){
                        if($this->Users->save($userData)){
                            $message = "Password updated successfully";
                            $this->Flash->custom_success(__($message));
                            return $this->redirect(['controller'=>'Users','action'=>'login']);
                        }else{
                            $message = "Something went wrong, please try again.";
                            $this->Flash->custom_error(__($message));
                            return $this->redirect(['controller'=>'Users','action'=>'login']);
                        }

                    } else {
                        $message = "Unable to Update: - ";
                        foreach($errors as $key=>$val){
                            if(array_key_exists('_empty', $val)){
                                $message .= $val['_empty'];
                            }elseif(array_key_exists('custom', $val)){
                                $message .= $val['custom'];
                            }
                            break;
                        }
                        $this->Flash->custom_error(__($message));
                        return $this->redirect(['controller'=>'Users','action'=>'login']);
                    }
                }

            }else{

                if(!$tokenValid){
                    $message = "Reset Password Token Expired, please try again.";
                    $this->Flash->custom_error(__($message));
                    return $this->redirect(['controller'=>'Users','action'=>'login']);
                }

                return $this->redirect(['controller'=>'Users','action'=>'login']);

            }
            $this->set(['token'=>$token,'title'=>'Reset Password']);
        }else{
            return $this->redirect(['controller'=>'Users','action'=>'login']);
        }
    }


    public function readingList()
    {
        $this->loadModel('ReadingList');
        $query = $this->ReadingList->find()->contain(['Users' => function($q){
            return $q->select(['name']);
        }])->where(['user_id' => $this->Auth->user('id')]);
        $ReadingList = $this->paginate($query,['order' => ['ReadingList.id' => 'Desc'] ]);
        $this->set('ReadingList', $ReadingList);
    }

    public function addReadList($id = null)
    {
        $this->loadModel('ReadingList');
        $ReadingListEnt = $this->ReadingList->newEntity();
        if($this->request->is('post')){
            if(!empty($this->request->data['id'])){
                $ReadingListEnt->id = $this->request->data['id'];
            }
            $ReadingListEnt->title = $this->request->data['title'];
            $ReadingListEnt->user_id = $this->Auth->user('id');
            $ReadingListEnt->link = $this->request->data['link'];
            $ReadingListEnt->created = date('Y-m-d H:i:s');
            if($this->ReadingList->save($ReadingListEnt)){
                $message = "List has been updated successfully.";
                $this->Flash->custom_success(__($message));
                return $this->redirect(['controller' => 'Users','action' => 'readingList']);
            }
        }
        if($id != null){
            $this->request->data = $this->ReadingList->find()->where(['id' => $id])->hydrate(false)->first();
        }
        $this->set('ReadingListEnt',$ReadingListEnt);
    }

    public function deleteReadList($id = null)
    {
        if($id != null){
             $this->loadModel('ReadingList');
            $ReadingListEnt = $this->ReadingList->get($id);
            if($this->ReadingList->delete($ReadingListEnt)){
                $message = "List has been delete successfully.";
                $this->Flash->custom_success(__($message));
                return $this->redirect(['controller' => 'Users','action' => 'readingList']);
            }
        }
    }

    public  function updateTheses(){
        if($this->request->is('ajax')){
            $this->viewBuilder()->layout(false);
            $this->autoRender = false;
            $this->loadModel('Theses');
            $this->Theses->updateAll(['status' => 0],[]);
            $this->request->data['created'] = date('Y-m-d H:i:s');
            $entity = $this->Theses->newEntity($this->request->data);
            if($this->Theses->save($entity)){
                echo  json_encode(array('status' => 1));
            } else {
                echo  json_encode(array('status' => 0));
            }
        }
    }

    public function readingAllList()
    {
        $this->loadModel('ReadingList');
        $query = $this->ReadingList->find()->contain(['Users' => function($q){
            return $q->select(['name']);
        }])->hydrate(false) ;
        $readingAllList = $this->paginate($query,['order' => ['ReadingList.id' => 'Desc'] ]);  
        $this->set('readingAllList',$readingAllList);
    }


    function createDateRange($startDate, $endDate, $format = "Y-m-d")
    {
        $begin = new DateTime($startDate);
        $end = new DateTime($endDate);
        $interval = new DateInterval('P1D'); // 1 Day
        $dateRange = new DatePeriod($begin, $interval, $end);

        $range = [];
        foreach ($dateRange as $date) {
            $range[] = $date->format($format);
        }

        return $range;
    }
    /*
     * function to send  news email to users
     */
    public function sendEmail(){
        die();
        ini_set('memory_limit', '-1');
        $this->viewBuilder()->setLayout(FALSE); 
	$this->loadModel('Users');
        $this->loadModel('Organizations');
        $this->loadModel('OrganizationsNews');
        $this->loadModel('OrganizationsInvestors');
        $this->loadModel('OrganizationsFounders');
        $this->loadModel('PortfolioNews');
        $siteUrl = Configure::read('SITEURL').'/';
        $date = date('Y-m-d');
        $lastweekdate= date("Y-m-d",strtotime("-1 week"));
        $reviewCount=array();
        $day = date('l');
        $CronSettings = $this->CronSettings->find('list',['keyField' => 'id' ,'valueField' => 'service_type'])->where(['week_day'=> $day ])->hydrate(false)->toArray();
        //if(isset($CronSettings) && !empty($CronSettings) && $CronSettings[4]=='NewsEmail') {
        //Wednesday for Tiresisa Thursday for Jiyonce
           if($day=='Wednesday'){
        
        /*
         * get portolio news
         */
        
      
        $previous_week = strtotime("-1 week +2 day");
        $start_week = strtotime("last monday midnight",$previous_week);
        $end_week = strtotime("next sunday",$start_week);
        $start_week = date("Y-m-d",$start_week);
        $end_week = date("Y-m-d",$end_week);
        $getOrganisations= $this->Organizations->find('all')->where(['source'=>'crunchbase','funding_type IN'=>['angel','seed'],'date(`created`) >=' =>  $start_week,'date(`created`) <=' => $end_week])->order('total_funding_usd DESC')->limit(7)->hydrate(false)->toarray(); 
        $getOrganizationsList = $this->Organizations->find('all')->contain(['AllReviews'])->where(['source'=>'crunchbase','date(`created`) >=' =>  $start_week,'date(`created`) <=' => $end_week])->order(['id'=>'DESC'])->hydrate(false)->toArray();
	$getUser = $this->Users->find('all')->where(['role'=>0])->hydrate(false)->toArray();
        $getEmail =[];
        foreach($getUser as $userData){
            $getEmail[] = $userData['username'];
        }  
        //$getEmail[]='tqminternal@gmail.com';
        //pr($getEmail);die;
        $user_id =  $this->request->session()->read('Auth.Admin.id');
        $getDate = $this->Users->find()->where( [ 'id' => $user_id ] )->hydrate( false )->first();
        $dataformat = $getDate['date_format']; 
        if($dataformat==3){
              $dateConvert =  date('l d-m-Y');
         }
         else if($dataformat==2){
           $dateConvert =  date('l Y-m-d');
          }
          else if($dataformat==1){
              $dateConvert =    date('l m-d-Y');
          }
          else {
              $dateConvert =    date('l d-m-Y');
          }
        
        $totalReviewCount=array();
        $totalReviewUp=array();
        $totalReviewDown=array();
         
         foreach($getOrganizationsList as $reviewList){
            if(!empty($reviewList['all_reviews'])){
                foreach($reviewList['all_reviews'] as $reviewList ) {
                   //pr($reviewList);
                   $totalReviewCount[]=$reviewList['review'];
                    if($reviewList['review']==0){
                        $totalReviewDown[]=$reviewList['review'];
                    }
                    if($reviewList['review']==1){
                        $totalReviewUp[]=$reviewList['review'];
                    }
                }
                        
                    }   
         }
     
           $totalOrganisationNo =count($getOrganizationsList);
           $totalReviewNo =count($totalReviewCount);
           $totalReviewUpNo =count($totalReviewUp);
           $totalReviewDownNo =count($totalReviewDown);
           $emailTo=array('tqminternal@gmail.com');
           $mailData     = [];
           $mailData['totalOrganisationNo']     = $totalOrganisationNo;
           $mailData['totalReviewNo']     = $totalReviewNo;
           $mailData['totalReviewUpNo']     = $totalReviewUpNo;
           $mailData['totalReviewDownNo']     = $totalReviewDownNo;
           $mailData['organizationlist']     = $getOrganisations;
           $mailData['getDate']     = $dateConvert;
           $mailData['siteUrlLogo'] =$siteUrl;
           $count=1;
           foreach($getOrganisations as $orgDetails){
                $orgInvestors = $this->OrganizationsInvestors->find('all')->where(['organization_id'=>$orgDetails['id']])->order(['number_of_investments'=>'desc'])->hydrate(false)->toArray();
                $investor=array();
                foreach($orgInvestors as $investors){
                 $investor[]=$investors['name'];
                }
                //echo implode (",",$investor);
                $str1='';
                $str2='';
                $str3='';
                $getOrgNews = $this->OrganizationsNews->find('all')->where(['organization_id'=>$orgDetails['id']])->hydrate(false)->limit(1)->toArray();
                if($count==1){
                if(isset($getOrgNews) && !empty($getOrgNews)){
                  $str1='<tr><td valign="middle" width="100%" style="text-align: left; font-size: 14px; color: rgb(128, 128, 128); line-height: 22px; font-weight: 400; font-family: Helvetica,Arial,sans-serif; border-bottom: 1px solid rgb(224, 224, 224); padding-bottom:30px;">
                                                                                        <h1 height="35" width="100%" style="text-align: left; font-family: Helvetica,Arial,sans-serif,Open Sans; color: rgb(52, 75, 97); line-height: 32px; margin: 10px 0px 0px; padding: 0px; font-weight: normal; font-size: 20px;">'.$orgDetails["formal_company_name"].' get total  funding of $'.$this->nice_number($orgDetails["total_funding_usd"]).' </h1>
                                                                                         '.$getOrgNews[0]["title"].'
                <a target ="_blank" href="'.$getOrgNews[0]['url'].'" style="font-size: 14px;text-decoration: none;font-family: Helvetica,Arial,sans-serif; display: block; border: 1px solid rgb(92, 144, 186); width: 100px; text-align: center; line-height: 29px; border-radius: 3px; margin-top:20px; color: rgb(92, 144, 186);">Read more</a></td></tr><tr><td width="100%" height="5"></td></tr>';
                    $mailData['newsData1']=$str1; 
                           }
                           else {
                             $mailData['newsData1']="";
                           }
                }
                if($count==2){
                        if(isset($getOrgNews) && !empty($getOrgNews)){
                  $str2='<tr><td valign="middle" width="100%" style="text-align: left; font-size: 14px; color: rgb(128, 128, 128); line-height: 22px; font-weight: 400; font-family: Helvetica,Arial,sans-serif; border-bottom: 1px solid rgb(224, 224, 224); padding-bottom:30px;">
                                                                                        <h1 height="35" width="100%" style="text-align: left; font-family: Helvetica,Arial,sans-serif,Open Sans; color: rgb(52, 75, 97); line-height: 32px; margin: 10px 0px 0px; padding: 0px; font-weight: normal; font-size: 20px;">'.$orgDetails["formal_company_name"].' get total  funding of $'.$this->nice_number($orgDetails["total_funding_usd"]).' </h1>
                                                                                         '.$getOrgNews[0]["title"].'<a  target ="_blank" href="'.$getOrgNews[0]['url'].'" style="font-size: 14px;text-decoration: none;font-family: Helvetica,Arial,sans-serif; display: block; border: 1px solid rgb(92, 144, 186); width: 100px; text-align: center; line-height: 29px; border-radius: 3px; margin-top:20px; color: rgb(92, 144, 186);">Read more</a></td></tr><tr><td width="100%" height="5"></td></tr>';
                    $mailData['newsData2']=$str2;  
                        }
                        else{
                     $mailData['newsData2']='';
                 }
                }
                if($count==3){
                 if(isset($getOrgNews) && !empty($getOrgNews)){

                  $str3='<tr><td valign="middle" width="100%" style="text-align: left; font-size: 14px; color: rgb(128, 128, 128); line-height: 22px; font-weight: 400; font-family: Helvetica,Arial,sans-serif;  padding-bottom:20px;"><h1 height="35" width="100%" style="text-align: left; font-family: Helvetica,Arial,sans-serif,Open Sans; color: rgb(52, 75, 97); line-height: 32px; margin: 10px 0px 0px; padding: 0px; font-weight: normal; font-size: 20px;">'.$orgDetails["formal_company_name"].' get total  funding of $'.$this->nice_number($orgDetails["total_funding_usd"]).' </h1>'.$getOrgNews[0]["title"].'<a  target ="_blank" href="'.$getOrgNews[0]['url'].'" style="font-size: 14px;text-decoration: none;font-family: Helvetica,Arial,sans-serif; display: block; border: 1px solid rgb(92, 144, 186); width: 100px; text-align: center; line-height: 29px; border-radius: 3px; margin-top:20px; color: rgb(92, 144, 186);">Read more</a></td></tr><tr><td width="100%" height="5"></td></tr>';
                         $mailData['newsData3']=$str3;
                 }else{
                     $mailData['newsData3']='';
                 }
                }
               $count++;
            }
            //for port folio news
            $getOrgNews = $this->OrganizationsNews->find('all')->where(['type'=>'portfolio'])->group(['formal_company_name'])->limit(3)->hydrate(false)->toArray();
            $countPortfolio=1;
            $strPortfolio1='';
            $strPortfolio2='';
            $strPortfolio3='';
            $strPortfolio4='';
              
            foreach($getOrgNews as $portfolioNews){
                   
                    
                     if($countPortfolio==1){
                           
                  $strPortfolio1='<tr><td valign="middle" width="100%" style="text-align: left; font-size: 14px; color: rgb(128, 128, 128); line-height: 22px; font-weight: 400; font-family: Helvetica,Arial,sans-serif; border-bottom: 1px solid rgb(224, 224, 224); padding-bottom:30px;">
                                                                                        <h1 height="35" width="100%" style="text-align: left; font-family: Helvetica,Arial,sans-serif,Open Sans; color: rgb(52, 75, 97); line-height: 32px; margin: 10px 0px 0px; padding: 0px; font-weight: normal; font-size: 20px;">'.$portfolioNews["formal_company_name"].' get total  funding of $'.$this->nice_number($portfolioNews["total_funding_usd"]).' </h1>
                                                                                         '.$portfolioNews["title"].'
                <a target ="_blank" href="'.$portfolioNews['url'].'" style="font-size: 14px;text-decoration: none;font-family: Helvetica,Arial,sans-serif; display: block; border: 1px solid rgb(92, 144, 186); width: 100px; text-align: center; line-height: 29px; border-radius: 3px; margin-top:20px; color: rgb(92, 144, 186);">Read more</a></td></tr><tr><td width="100%" height="5"></td></tr>';
                $mailData['newsDataPortfolio1']=$strPortfolio1; 
                      
                } 
                 if($countPortfolio==2){
                         
                  $strPortfolio2='<tr><td valign="middle" width="100%" style="text-align: left; font-size: 14px; color: rgb(128, 128, 128); line-height: 22px; font-weight: 400; font-family: Helvetica,Arial,sans-serif; border-bottom: 1px solid rgb(224, 224, 224); padding-bottom:30px;">
                                                                                        <h1 height="35" width="100%" style="text-align: left; font-family: Helvetica,Arial,sans-serif,Open Sans; color: rgb(52, 75, 97); line-height: 32px; margin: 10px 0px 0px; padding: 0px; font-weight: normal; font-size: 20px;">'.$portfolioNews["formal_company_name"].' get total  funding of $'.$this->nice_number($portfolioNews["total_funding_usd"]).' </h1>
                                                                                         '.$portfolioNews["title"].'
                <a target ="_blank" href="'.$portfolioNews['url'].'" style="font-size: 14px;text-decoration: none;font-family: Helvetica,Arial,sans-serif; display: block; border: 1px solid rgb(92, 144, 186); width: 100px; text-align: center; line-height: 29px; border-radius: 3px; margin-top:20px; color: rgb(92, 144, 186);">Read more</a></td></tr><tr><td width="100%" height="5"></td></tr>';
                     $mailData['newsDataPortfolio2']=$strPortfolio2; 
                  
                     
                }
                if($countPortfolio==3){
                           
                  $strPortfolio3='<tr><td valign="middle" width="100%" style="text-align: left; font-size: 14px; color: rgb(128, 128, 128); line-height: 22px; font-weight: 400; font-family: Helvetica,Arial,sans-serif; border-bottom: 1px solid rgb(224, 224, 224); padding-bottom:30px;">
                                                                                        <h1 height="35" width="100%" style="text-align: left; font-family: Helvetica,Arial,sans-serif,Open Sans; color: rgb(52, 75, 97); line-height: 32px; margin: 10px 0px 0px; padding: 0px; font-weight: normal; font-size: 20px;">'.$portfolioNews["formal_company_name"].' get total  funding of $'.$this->nice_number($portfolioNews["total_funding_usd"]).' </h1>
                                                                                         '.$portfolioNews["title"].'
                <a target ="_blank" href="'.$portfolioNews['url'].'" style="font-size: 14px;text-decoration: none;font-family: Helvetica,Arial,sans-serif; display: block; border: 1px solid rgb(92, 144, 186); width: 100px; text-align: center; line-height: 29px; border-radius: 3px; margin-top:20px; color: rgb(92, 144, 186);">Read more</a></td></tr><tr><td width="100%" height="5"></td></tr>';
                   $mailData['newsDataPortfolio3']=$strPortfolio3; 
                    
                         
                }
                    $countPortfolio++;
                      
                  }
            
                    
           $from_email   = Configure::read('from_email');
           $project_name = Configure::read('project_name');
           $mailData['link'] = rand();
           $time_expire      = strtotime("+15 minutes",strtotime(date('Y-m-d H:i:s')));
           $token_expire     = date('Y-m-d H:i:s',$time_expire);
           $this->set('mailData',$mailData);
           //echo $this->render('/Email/html/leademail');  
            //die;
               
               $email       = new Email();
               $email       = $email
                               ->viewVars($mailData)
                               ->template('leademail')
                               ->emailFormat('html')->to($getEmail)
                               ->subject('Social Start')
                               ->from([$from_email => $project_name]);
                        
                if($email->send()){
                    echo "mail send";
                }else{
                    echo "mail not send";
                    
                }
            
          }   
            
          die;
        
        
    }
    
    
    
    public function sendCustomEmail() {
      $siteUrl = Configure::read('SITEURL');
      $from_email   = Configure::read('from_email');
      $project_name = Configure::read('project_name');

      $day = date('l');
      if($day=='Thursday') {               
        $time_expire      = strtotime("+15 minutes",strtotime(date('Y-m-d H:i:s')));
        $token_expire     = date('Y-m-d H:i:s',$time_expire);
        $mailData['link'] = rand();
        $mailData['siteUrlLogo'] =$siteUrl;

        $getUser = $this->Users->find('all')->hydrate(false)->toArray();
        $getEmail =[];
        foreach($getUser as $userData){
          $getEmail[] = $userData['username'];
        } 
        //$emailTo='tqminternal@gmail.com';
        $email       = new Email();
        $email       = $email
                        ->viewVars($mailData)
                        ->template('customemail')
                        ->emailFormat('html')
                        ->bcc($getEmail)
                        //->to('andrew@socialstarts.com')
                        ->subject('Voting Open')
                        ->from([$from_email => $project_name]);
        if($email->send()) {
          echo "mail send";
        }else{
          echo "mail not send";
        }
      }
      die;
    }
    
    
    function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n/1000000000000), 2).' Trillion';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).' Billion';
        elseif ($n > 1000000) return round(($n/1000000), 2).' Million';
        elseif ($n > 1000) return round(($n/1000), 2).',000';

        return number_format($n);
    }
  

  public function groups($id = null)
    {
        $this->loadModel('UsersGroups');
        $groupEnt = $this->UsersGroups->newEntity();
        if($this->request->is('post'))
        {
             $message = "User Has Been Added Successfully";
            $this->request->data['modified'] = date('Y-m-d H:i:s');
            if(!empty($this->request->data['id'])){
              $groupEnt =  $this->UsersGroups->get($this->request->data['id']);
              $message = "User Has Been Edited Successfully";
            } else {
              $this->request->data['created'] = date('Y-m-d H:i:s');
            }
            $userdata = $this->UsersGroups->patchEntity($groupEnt, $this->request->data);
            if($this->UsersGroups->save($userdata)){
                $this->Flash->custom_success(__($message));
                 return $this->redirect(['controller' => 'Users','action' => 'groups']);
            }

        }
        if($id != null){
            $this->request->data = $this->UsersGroups->find()->select(['id','name'])->where(['id' => $id])->hydrate(false)->first();
        }

        $groups = $this->UsersGroups->find()->hydrate(false)->toArray();
        $this->set(compact('groupEnt','groups'));
    }   


  public function groupDelete($id = null){
    if(!empty($id) && $id != null){
      $this->loadModel('UsersGroups');
      $UsersGroups = $this->UsersGroups->get($id);
      if($this->UsersGroups->delete($UsersGroups)){
        $this->Flash->custom_success(__('Group has been deleted'));
        return $this->redirect("/users/groups");
      }
    }        
  } 


  public function profile(){
        $this->loadModel('Users');
        $userEnt = $this->Users->newEntity();
        if($this->request->is('post'))
        {
          $userEnt =  $this->Users->get($this->request->session()->read('Auth.Admin.id'));
          $message = "User Has Been Added Successfully";
          if(isset($this->request->data['avtar']['name']) && !empty($this->request->data['avtar']['name'])){
            $file = date('dmyhis').'-'.$this->request->data['avtar']['name'];
            //echo WWW_ROOT.'img'.DS.'avtar'.DS.$file;
            move_uploaded_file($this->request->data['avtar']['tmp_name'],WWW_ROOT.'avtar'.DS.$file); 
            $this->request->data['avtar']  = $file;
          } else {
            unset($this->request->data['avtar']);
          }
          $userdata = $this->Users->patchEntity($userEnt, $this->request->data);
          if($this->Users->save($userdata)){
            $this->Flash->custom_success(__($message));
            return $this->redirect(['controller' => 'Users','action' => 'profile']);
          }
        }
        $this->request->data = $this->Users->find()->where(['id' => $this->request->session()->read('Auth.Admin.id')])->hydrate(false)->first();
        $this->loadModel('UsersGroups');
        $groups = $this->UsersGroups->find('list',[
            'keyField' => 'id',
            'valueField' => 'name'
          ])->hydrate(false)->toArray();

        $this->set('userEnt',$userEnt);
        $this->set('groups',$groups);
     }


      public function portfolioCompanies($id = null, $action = null) {
        $this->loadModel('PortfolioCompanies');
        $portfolioCompaniesEnt = $this->PortfolioCompanies->newEntity();
        if($this->request->is('post') && isset($this->request->data['company'])) {
          $userdata = $this->PortfolioCompanies->patchEntity($portfolioCompaniesEnt, $this->request->data);
          if($this->PortfolioCompanies->save($userdata)){
                $this->Flash->custom_success(__('Portfolio Company has been updated successfully.'));
                return $this->redirect(['controller' => 'Users','action' => 'portfolioCompanies']);
          }
        }
        if($id != null && $action == null){
          $this->request->data = $this->PortfolioCompanies->find()->where(['id' => $id])->hydrate(false)->first();
        } else if($id != null && $action == 'trash') {
          $deleteEnt = $this->PortfolioCompanies->get($id);
          if($this->PortfolioCompanies->delete($deleteEnt) ){
            $this->Flash->custom_success(__('Portfolio Company has been deleted successfully.'));
            return $this->redirect(['controller' => 'Users','action' => 'portfolioCompanies']);
          }
        }
        $this->paginate = ['limit' => 100,'order' => ['company' => 'ASC']];
        $portfolioCompaniesQ = $this->PortfolioCompanies->find('list',['keyField' => 'id' ,'valueField' => 'company'])->hydrate(false);
        $portfolioCompanies = $this->paginate($portfolioCompaniesQ);    
        $this->set(compact('portfolioCompaniesEnt','portfolioCompanies'));
        if($this->request->is('ajax')){
          $this->viewBuilder()->layout(false);
        }
      }



        public function transom(){
    $this->loadModel('Transom');
    $this->paginate = ['limit' => 24,'order' => ['id' => 'DESC']];
    $query = $this->Transom->find()->hydrate(false);
    $transoms = $this->paginate($query);
    $this->set('transoms',$transoms);    
  }
  public function transomDetail($id = null){
    $this->loadModel('Transom');
    $transom = $this->Transom->find()->where(["id" => $id])->hydrate(false)->first();
    $this->set('transom',$transom);    
  }

  public function transomRefreshList(){
      $this->viewBuilder()->setLayout(false);
      $this->autoRender = false;
      $absolutepath =  dirname(__FILE__).'/../../vendor/googlesheet/quickstart.php';
      $output = shell_exec('php '.$absolutepath);
      // return $this->redirect(['controller' => 'Users','action' => 'transom']);
    }

    public function importportfolio(){
      require_once(ROOT .DS. 'vendor' . DS . 'SimpleXlsx' . DS . 'SimpleXlsx.php');
      if(!empty($_FILES["import"]["name"])){
          $uploadFilePath=WWW_ROOT . 'import/'.$_FILES['import']['name'];
          move_uploaded_file($_FILES['import']['tmp_name'], $uploadFilePath);
          if ($xlsx = SimpleXLSX::parse($uploadFilePath)) {
              $key = 1;
              foreach($xlsx->rows() as $rowData){
                if($key == 1 || empty($rowData[1])){ $key ++; continue; }
                $this->loadModel('PortfolioCompanies');
                if(!$this->PortfolioCompanies->exists(array("company" => $rowData[1]))) {
                  $data = array(
                    'company' => $rowData[1],
                    'status' => $rowData[0],
                    'aka' => $rowData[2],
                    'user_id' => $this->Auth->user('id'),
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                  );
                  $dataEnt = $this->PortfolioCompanies->newEntity($data);
                  $this->PortfolioCompanies->save($dataEnt);
                }
                
              }
          }
      }
      $this->Flash->custom_success(__('Portfolio Company has been imported successfully.'));
      return $this->redirect(['controller' => 'Users','action' => 'portfolioCompanies']);
    }

}

