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
use Cake\ORM\TableRegistry;

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

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $session = $this->request->session();
        $user = $session->read('authentication');
        $cart = $session->read('my_cart');

            // $session->delete('my_cart');
            // die;
            
        
        $categorys = TableRegistry::get('Categorys')->find('all');
        $this->set('categorys', $categorys);

        if(isset($cart)) {
            
            foreach($cart as $key => $value) {
                $array_id[] = $value['product_id'];
            }
            
            if(isset($array_id)) {
                $array_id = array_merge($array_id);

                $products = TableRegistry::get('products')->find('all')->where(['product_id IN' => $array_id]);  
                foreach($cart as $key => $value) {
                    $session_cart[$value['product_id']] = $value['qty'];
                }

                $this->set('cart', $products);
                $this->set('session_cart', $session_cart);
               
            }
            
        }

        $this->set('user', $user); 
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

}
