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
namespace App\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;

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

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */

    public function initialize()
    {
        parent::initialize();
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $this->viewBuilder()->layout('admin');

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
                            'loginRedirect' => [
                                'controller' => 'home',
                                'action'     => 'index'

                            ], 'logoutRedirect' => [
                                'controller' => 'users',
                                'action' => 'login'
                            ] 

                        ]);
       

        $this->loadComponent('AkkaFacebook.Graph', [
            'app_id' => '1749197665350898',
            'app_secret' => '270ebc5f68ac70bfe8808c3bc8dd234e',
            'app_scope' => 'email,public_profile', // https://developers.facebook.com/docs/facebook-login/permissions/v2.4
            'redirect_url' => Router::url(['controller' => 'Users', 'action' => 'login'], TRUE), // This should be enabled by default
            'post_login_redirect' => '' //ie. Router::url(['controller' => 'Users', 'action' => 'account'], TRUE)
            // 'user_columns' => ['first_name' => 'fname', 'last_name' => 'lname', 'username' => 'uname', 'password' => 'pass'] //not required
        ]);
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        } 
    }

    public function isAuthorized($user) {
        if($user['role'] && $user['role'] == 'admin') {
            return true;
        }
        return false;
    }
    
}
