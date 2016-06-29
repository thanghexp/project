<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class CartsController extends AppController {

	public function initialize() {
		parent::initialize();
	}

	public function orderCart() {
		$session = $this->request->session();
		$cart = $session->read('my_cart');

		$productsTable = TableRegistry::get('products');
		if(isset($cart)) {
			
			foreach($cart as $key  => $value) {
				$array_id[] =  $value['product_id'];
			}

			foreach ($cart as $key => $value) {
				$session_cart[$value['product_id']] = $value['qty'];
			}

			$products = $productsTable->find('all')->where(['product_id IN' => $array_id]);

			$this->set('cart', $session_cart);
			$this->set('products_cart', $products);
	

		} else {
			$this->Flash->error('My cart have empty !!');
			$this->redirect(['controller' => 'products', 'action' => 'view-product']);
		}

	}

	public function updateCart() {
		if($this->request->is('POST')) {
			$session = $this->request->session();
			$cart = $session->read('my_cart');
			$data = $this->request->data();

			foreach($data['qty'] as $key => $value) {					
				if(isset($cart)) {
					foreach($cart as $k_cart => $v_cart) {

						if($v_cart['product_id'] == $key) {
							$cart_update = ['product_id' => $key, 'qty' => $value];
							$session->write('my_cart.' . $k_cart , $cart_update);	
						}

					}

				}
			}
			return $this->redirect(['controller' => 'products', 'action' => 'orderCart']);
		}
	}


	public function removeCart($product_id) {
		$session = $this->request->session();
		$cart = $session->read('my_cart');

		foreach($cart as $key => $value) {
			if($value['product_id'] == $product_id) {
				$session->delete('my_cart.' .$key);				
			}
		}

		return $this->redirect(['controller' => 'products', 'action' => 'orderCart']);
	}

	public function saveCart() {
		$session = $this->request->session();
		$user = $session->read('authentication');

		$cart = $session->read('my_cart');

		if($user) {	
			$ordersTable = TableRegistry::get('orders');
			$order = $ordersTable->newEntity();
			$order->customer_id = $user['customer_id'];

			$orderSave = $ordersTable->save($order);	

			$cart = $session->read('my_cart');
			if($cart) {
				
				$invoicesTable = TableRegistry::get('invoices');
				$productsTable = TableRegistry::get('products');

				
				foreach($cart as $key => $value) {

					$product = $productsTable->find('all')->where(['product_id' => $value['product_id']])->first();
					$product->qty = $value['qty'] - $value['qty'];
					$productsTable->save($product);

					$invoice = $invoicesTable->newEntity();
					$invoice->order_id = $orderSave->order_id;
					$invoice = $invoicesTable->patchEntity($invoice, $value);	
					$invoicesTable->save($invoice);
				}

				// $this->redirect->
				die;
			}

		} else  {
			$session->write('flash', ['controller' => 'products', 'action' => 'orderCart']);
			$this->redirect(['controller' => 'users', 'action' => 'login']);
		}
	}

}