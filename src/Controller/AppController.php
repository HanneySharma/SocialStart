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
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $pagelimit = 100;
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize( )
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
        
        $this->loadComponent('Auth', [
                'authenticate' => array(
                    'Form' => array(
                        'fields' => ['username' => 'username', 'password' => 'password']
                    )
                ),
                'loginRedirect' => [
                    'controller' => 'Users',
                    'action' => 'dashboard'
                ],
                'logoutRedirect' => [
                    'controller' => 'Users',
                    'action' => 'login'
                ],
                'storage' => [
                    'className' => 'Session',
                    'key' => 'Auth.Admin',               
                ]
            ]);
       if($this->Auth->user()) {
            $this->loadModel('Users');
           $userId = $this->Auth->user('id');   
           $loggeinuserdata = $this->Users->find()->select(['id','name','username','avtar','role','users_group_id','date_format'])->where([ 'id' => $userId ] )->hydrate( false )->first();
           $dataformat = $loggeinuserdata['date_format'];
           $this->set(compact('dataformat','loggeinuserdata'));         
         }               
    }
    
    public function beforeFilter(Event $event)
    {
        //echo $this->request->params['action']; 
      if(isset($this->request->params) && ($this->request->params['action']=='addFilter')){
          $this->set('title_update','Manage Filter');
      }
      else if(isset($this->request->params) && ($this->request->params['action']=='addDate')){
          $this->set('title_update','Manage Date Format');
      }
      else if(isset($this->request->params) && ($this->request->params['action']=='readingList')){
          $this->set('title_update','Reading List');
      }
      else if(isset($this->request->params) && ($this->request->params['action']=='categories')){
          $this->set('title_update','Manage Categories');
      }
      else if(isset($this->request->params) && ($this->request->params['action']=='settings')){
          $this->set('title_update','Setting');
      } 
       else if(isset($this->request->params) && ($this->request->params['action']=='dashboard')){
          $this->set('title_update','Dashboard');
      }
      else if(isset($this->request->params) && ($this->request->params['action']=='businessIntelligence')){
          $this->set('title_update','Business Intelligence');
      }
      else if(isset($this->request->params) && ($this->request->params['action']=='processedLeads')){
          $this->set('title_update','Processed Leads');
      }
      
        // setup out Auth
        $this->Auth->allow(['login']);
        $siteURL = Configure::read('SITEURL');
        $this->set('siteURL', $siteURL);
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
  public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}
