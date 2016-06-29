<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class CartsController extends AppController {

	public function initialize() {
		parent::initialize();
	}

	public function orderCart() {
		
		$session = $this->request->session();
		$cart    = $session->read('my_cart');
		$flash   = $session->read('flash');

		if($flash) {
			$session->delete('flash');
		}
		
		$productsTable = TableRegistry::get('products');
		if(isset($cart) && count($cart) > 0) {
			
			foreach($cart as $key  => $value) {
				$array_id[] =  $value['product_id'];
			}

			foreach ($cart as $key => $value) {
				$session_cart[$value['product_id']] = $value['qty'];
			}
					
			$products = $productsTable->find('all')->where(['product_id IN' => $array_id]);
			
			$this->set('products', $products);
			$this->set('cart', $session_cart);
			$this->set('products_cart', $products);
	
		} else {
			$this->Flash->error('Your cart empty !!');
			$this->redirect(['controller' => 'products', 'action' => 'view-product']);
		}

	}

	public function updateCart() {
		if($this->request->is('POST')) {
			$session = $this->request->session();
			$cart    = $session->read('my_cart');
			$data    = $this->request->data();

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
			return $this->redirect(['controller' => 'carts', 'action' => 'orderCart']);
		}
	}


	public function removeCart($product_id) {
		$session = $this->request->session();
		$cart    = $session->read('my_cart');

		if($cart) {
			foreach($cart as $key => $value) {
				if($value['product_id'] == $product_id) {
					$session->delete('my_cart.' .$key);				
				}
			}
		}

		return $this->redirect(['controller' => 'carts', 'action' => 'orderCart']);
	}

	public function saveCart() {
		
		$session = $this->request->session();
		$user    = $session->read('authentication');
		$cart    = $session->read('my_cart');

		if($user) {	
			$ordersTable        = TableRegistry::get('orders');
			$row_order          = $ordersTable->find('all')->last();
			
			$order              = $ordersTable->newEntity();
			$order->customer_id = $user['customer_id'];
			$order->code_order  = 'MSO50' . ($row_order->order_id + 1);
			$order->created     = Time::now();
			$orderSave          = $ordersTable->save($order);	
			
			$cart               = $session->read('my_cart');
			
			if($cart) {
				
				$orderProductsTable = TableRegistry::get('order_products');
				$productsTable = TableRegistry::get('products');
				
				foreach($cart as $key => $value) {

					$product                  = $productsTable->find('all')->where(['product_id' => $value['product_id']])->first();
					$product->qty             = $product->qty - $value['qty'];
					$productsTable->save($product);
					
					$order_products           = $orderProductsTable->newEntity();
					$order_products->order_id = $orderSave->order_id;
					$order_products->created  = Time::now();
					$order_products           = $orderProductsTable->patchEntity($order_products, $value);	
					$orderProductsTable->save($order_products);
				}

				return $this->redirect(['controller' => 'carts', 'action' => 'listOrderDone']);
			}

		}

		$session->write('flash', ['controller' => 'carts', 'action' => 'orderCart']);
		$this->redirect(['controller' => 'customers', 'action' => 'login']);
		
	}

	public function listOrderDone() {
		$session = $this->request->session();
		// $session->delete('my_cart');	

		$ordersTable        = TableRegistry::get('orders');		
		$invoicesTable      = TableRegistry::get('invoices');
		$orderProductsTable = TableRegistry::get('order_products');

		$orders = $ordersTable->find('all')->last();
		// debug($orders); die;
		$order_products = $orderProductsTable->find('all')
											 ->where(['order_id' => $orders->order_id])
											 ->contain(['products'])->toArray();

		// debug($order_products); die;
								  
		$query = $orderProductsTable->find();

		$sum_money = $query->select(['sum_money' => $query->func()
									->sum('order_products.qty * products.price')])
									->where(['order_id' => $orders->order_id])
									->group('order_id')
									->contain(['products'])->first();


		$this->set('sum_money', $sum_money['sum_money']);
		$this->set('code_id', $orders->code_order);
		$this->set('order_products', $order_products);
		$this->Flash->success(__('You have order product success !'));
		// return $this->redirect(['controller' => 'home', 'action' => 'index']);
	} 

	public function history() {
		$session = $this->request->session();
		$invoicesTable = TableRegistry::get('invoices');
		$ordersTable   = TableRegistry::get('orders');

		if($this->request->is('POST')) {
			$data     = $this->request->data();
			$invoices = $invoicesTable->find('all')->where(['order_id' => $data['order_id']]);

			foreach ($invoices as $invoice) {
				$cart[] = [
							'product_id' => $invoice->product_id,
							'qty'        => $invoice->qty 
						];
			}

			$session->write('my_cart', $cart);
			return $this->redirect(['controller' => 'carts', 'action' => 'orderCart']);
		}

		$user = $session->read('authentication');

		if(isset($user)) {
			$orders = $ordersTable->find('all')->where(['customer_id' => $user['customer_id']]);
			foreach($orders as $order) {
				$array_id_orders[] = $order->order_id;
			}

			$query = $invoicesTable->find('all');
			$invoices = $query ->select(['invoices.order_id', 'invoices.created', 'money'=>'SUM(invoices.qty * products.price)' ])
								->where(['order_id IN' => $array_id_orders])
								->group('order_id')
								->contain(['products'])->toArray();

			$dropdown_date = $invoicesTable->find('list', [
											'keyField'   => 'order_id',
											'valueField' => 'created'
										])
									->group('order_id')
									->where(['order_id IN' => $array_id_orders]);

			$this->set('invoices', $invoices);	
			$this->set('dropdown_date', $dropdown_date);
		} else {
			$this->Flash->error(__('You login yet'));
			return $this->redirect(['controller' => 'home', 'action' => '']);
		}
	}

	public function dataInvoiceHistory() {
		$invoicesTable = TableRegistry::get('invoices');
		
		$data = $this->request->data();
		$invoices = $invoicesTable->find('all')->select([
													'invoices.order_id', 'invoices.created', 
													'money' => 'SUM(invoices.qty * products.price)'
												])
											   ->where(['order_id' => $data['order_id']])
											   ->group('order_id')
											   ->contain(['products'])->toArray();

        echo '<tr class="bg-primary"><th>#</th>';
        echo '<th>Order ID</th>';
        echo '<th>Total money</th>';
        echo '<th>Created date</th>';            
        echo '</tr>';  
        $i = 1;
		foreach($invoices as $invoice) {			
			echo "<tr>";
			echo "<td>". $i++ ."</td>";			
			echo "<td>". $invoice->order_id  ."</td>";
			echo "<td><b>" . number_format($invoice->money, 3) . "</b></td>";
			echo "<td>". $invoice->created  ."</td>";
			echo "</tr>";
		}
		die;
	}

}