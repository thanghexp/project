<?php 

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;	

class OrdersController extends AppController {

	public $paginate = [
						'limit' => 5,
					];

	public function initialize() {
		parent::initialize();
	}

	public function listOrder() 
	{
		$ordersTable        = TableRegistry::get('orders');
		$productsTable      = TableRegistry::get('products');
		$orderProductsTable = TableRegistry::get('orderProducts');
		
		$order_result = $ordersTable->find('all')
										->select([	
											'orders.order_id', 'customers.first_name', 
											'customers.last_name', 'created', 'updated',
											'orders.code_order', 'status'
										])
										->contain(['customers']);

		if($this->request->is('POST')) {
			$data = $this->request->data();
			$user = $this->Auth->user;

			if(isset($data['action'])) {
				if($data['action'] == 1) {
					// UPDATE` ARRAY STATUS
					foreach ($data['ids'] as $key => $value) {
						if($data['ids'][$key] == 1) {

							$params = $ordersTable->find('all')->where(['order_id' => $key])->first();

							if($params->status != 3) {

								$params->updated = Time::now();
								$params->status  = $data['status'];
								$params->user    = $user['user_id'];

								if($ordersTable->save($params)) {
									if($data['status'] == 3) {
										$rs_orderProducts = $orderProductsTable->find('all')->where(['order_id' => $params->order_id]);

										$total = 0;
										foreach($rs_orderProducts as $value) {
											$row_product = $productsTable->find('all')->where(['product_id' => $value['product_id']])->first();
											$total += $row_product->price * $value->qty;
										}

										$invoicesTable        = TableRegistry::get('invoices');
										$invoice              = $invoicesTable->newEntity();
										$invoice->order_id    = $params->order_id;
										$invoice->total_money = $total;
										$invoice->created     = Time::now();
										
										$invoicesTable->save($invoice);
									}
									$this->Flash->success(__('Update status for order '. $key . ' success !')); 		
								}
							} else {
								$this->Flash->error(__('This order status have been paid !')); 	
							}							
						}
					}
				} else {
					// DELETE ARRAY
					foreach ($data['ids'] as $key => $value) {
						if($data['ids'][$key] == 1) {
							$params = $ordersTable->find('all')->where(['order_id' => $key])->first();

							if($ordersTable->delete($params)) {
								$this->Flash->success(__('Delete order : '. $params->code_order . ' success !')); 		
							}
						}
					}
				}
			} else {
				if(isset($data['search'])) {
					if($data['search'] == 'search') {

						$order_result = $ordersTable->find('all')
													->select([	
														'orders.order_id', 'customers.first_name', 
														'customers.last_name', 'created', 'updated',
														'orders.code_order', 'status'
													])
													->where([
																'orders.code_order LIKE' => '%' . $data['search_code_order'] . '%',
																'orders.status LIKE' => $data['search_status'],
																'orders.updated LIKE' => '%' . $data['search_updated'] . '%'
															])
													->contain(['customers']);
					}
				} 
			}
		}

		if(!$order_result) {
			$this->Flash->error(__('Database Order table empty !'));
		}

		$dropdown_status = ['0' => 'Ordered', '1' => 'Approve', '2' => 'Transfer', '3' => 'Paid', '4' => 'Fail'];
		$dropdown_action = ['0' => 'Action', '1' => 'Update', '2' => 'Delete'];

		$this->set('dropdown_action', $dropdown_action);
		$this->set('dropdown_status', $dropdown_status);
		$this->set('orders', $this->paginate($order_result));
		$this->set('title', 'View list ordered !');
	}

	public function orderAtShop() {
		$ordersTable         = TableRegistry::get('orders');
		$order_productsTable = TableRegistry::get('order_products');
		$productsTable       = TableRegistry::get('products');
		
		$session             = $this->request->session();
		$flash_update = $session->read('flash_update');

		if(isset($flash_update)) {
			$session->delete('admin_cart');
			$session->delete('flash_update');
		}

		$cart                = $session->read('admin_cart');
		$user                =  $this->Auth->user();

		if($this->request->is('POST')) {
			if(count($cart) > 0) {
				$data      = $this->request->data();
				
				$row_order = $ordersTable->find('all')->last();
				$order     = $ordersTable->newEntity();

				if(!isset($row_order)) {
					$order->code_order = 'MSF5001';
				} else {
					$order->code_order = 'MSF50' . ( ( (int) $row_order->order_id) + 1);	
				}

				$order->name_desk = $data['name_desk'];
				$order->created   = Time::now();
				$order->user_id   =  $user['user_id'];		
				
				$order_save       = $ordersTable->save($order);

				if($order_save) {

					foreach($cart as $key => $value) {
						$orderProducts             = $order_productsTable->newEntity(); 
						
						$orderProducts->product_id = $value['product_id'];
						$orderProducts->qty        =  $value['qty'];									
						$orderProducts->created    = Time::now();
						$orderProducts->order_id   = $order_save->order_id;

						if($order_productsTable->save($orderProducts)) {
							// die;	
							$products      = $productsTable->find('all')->where(['product_id' => $orderProducts->product_id])->first(); 
							
							$products->qty = $products->qty - $orderProducts->qty;
							$productsTable->save($products);
						}

					}

					$this->Flash->success('Order success !');
					// $this->redirect(['controller' => 'orders', 'action' => 'listOrderDoneAtShop']);
					$this->redirect('/admin/orderProducts/listOrderProduct/' . $row_order->code_order);
				}

			} else {
				$this->Flash->error('Cart shopping empty !');
			}			

		}

		$dropdown_product = TableRegistry::get('products')->find('list', [
																	'keyField'   => 'product_id',
																	'valueField' => 'value'
															])
															->select([
																	'product_id', 
																	'value' => 'CONCAT(name_product, " --- Qty: ", qty, " --- ", price, ".000 VND" )'])
															->where(['qty >' => 0])
															->toArray();

		if(count($cart) > 0) {
			foreach($cart as $key => $value) {
				$row_product = $productsTable->find('all')->where(['product_id' => $value['product_id']])->first();
				$row_product->qty = $value['qty'];
				$list_product_order[] = $row_product;
			}
			$this->set('list_product_order', $list_product_order);		
		}	

		$this->set('dropdown_product', $dropdown_product);
	}

	public function removeCart($product_id) {
		$session = $this->request->session();
		$cart = $session->read('admin_cart');

		if(isset($product_id)) {
			if(count($cart) > 0) {

				foreach($cart as $key => $value) {
					if($value['product_id'] == $product_id) {
						$session->delete('admin_cart.' . $key);
						return $this->redirect(['controller' => 'orders', 'action' => 'orderAtShop']);
					}
				}

			}	
		} else {
			$this->redirect(['controller' => 'orders', 'action' => 'orderAtShop']);
		}
		
	}

	public function removeCartContact($product_id) {
		$session = $this->request->session();
		$cart = $session->read('admin_cart');

		if(isset($product_id)) {
			if(count($cart) > 0) {

				foreach($cart as $key => $value) {
					if($value['product_id'] == $product_id) {
						$session->delete('admin_cart.' . $key);
						return $this->redirect(['controller' => 'orders', 'action' => 'orderAtShop']);
					}
				}

			}	
		} else {
			$this->redirect(['controller' => 'orders', 'action' => 'addProductOrder']);
		}
		
	}

	// public function deleteCartUpdate($product_id) {
	// 	if(isset($product_id)) {
	// 		if(count($cart) > 0) {
	// 			foreach($cart as $key => $value) {
	// 				if($value['product_id'] == $product_id) {
	// 					$session->delete('admin_cart.' . $key);
	// 					return $this->redirect(['controller' => 'orders', 'action' => 'orderAtShop']);
	// 				}
	// 			}
	// 		}	
	// 	} 
	// }
	

	public function listOrderDoneAtShop() {

		$ordersTable   = TableRegistry::get('orders');
		$orderProductsTable = TableRegistry::get('order_products');

		$session = $this->request->session();
		$cart = $session->read('admin_cart');

		if(count($cart) > 0) {
			// Get recore last !! Wrong of  Table Orders
			$orders = $ordersTable->find('all')->last();

			$information_personal = $ordersTable->find('all')
												->select([
															'full_name' => 'CONCAT(customers.last_name, " ", customers.first_name )',
															'customers.address', 'customers.phone_number', 
															'orders.order_id', 'customers.email'
														])
												->contain(['customers'])
												->last()->toArray();								

			$order_products = $orderProductsTable->find('all')
									  ->where(['order_id' => $orders->order_id])
									  ->contain(['products'])
									  ->toArray(); 

			$query = $orderProductsTable->find();

			$sum_money = $query->select(['sum_money' => $query->func()
										->sum('order_products.qty * products.price')])
										->where(['order_id' => $orders->order_id])
										->group('order_id')
										->contain(['products'])->first()->toArray();
			
			$this->set('orders', $orders);										
			$this->set('sum_money', $sum_money['sum_money']);
			$this->set('info', $information_personal);
			$this->set('order_products', $order_products);
		} else {
			$this->redirect(['controller' => 'orders', 'action' => 'listOrder']);
		}		
		
		$session->delete('admin_cart');				
		
	}

	public function addMore() {

		$session = $this->request->session();
		$cart = $session->read('admin_cart');
		// debug($cart); die;
		$data = $this->request->data();
		if(count($data) > 0) {
			$row_products = TableRegistry::get('products')->find('all')->where(['product_id' => $data['product_id']])->first();
			// debug($row_products); die;

			if(isset($cart)) {

				if($data['qty'] > $row_products->qty) {
					echo $row_products->qty; die;
				} else {

					foreach($cart as $key => $value) {
						if($data['product_id'] == $value['product_id']) {
							$cart[$key] = $data;
							$session->write('admin_cart', $cart);
							$this->listOrderCart($cart);
							die;
						}
					} 

				}

			}

			$cart[] = $data;
			$session->write('admin_cart', $cart);
			$cart = $session->read('admin_cart');

			$this->listOrderCart($cart);
		}

		/*
			# Duplicate product_id => stack up $product_id => save session
			# have product_id => add session 
		*/
	}

	public function listOrderCart($cart) {
		$productsTable = TableRegistry::get('products');
		$session = $this->request->session();
		$flash = $session->read('flash_update');

		foreach($cart as $key => $value) {
			$row_product = $productsTable->find('all')->where(['product_id' => $value['product_id']])->first();
			
			echo "<tr>";
			echo "<td><b>". $row_product->product_id  ."</b></td>";
			echo "<td>". $row_product->name_product  ."</td>";
			echo "<td>". $value['qty']  ."</td>";
			echo "<td class='text-center'><b>". number_format($value['qty'] * $row_product->price, 3)."</b></td>";
			echo '<td><a href="' . $this->request->webroot . 'admin/orders/removeCart/'. $value['product_id'] .  '" onclick="checkDelete(event)">';
			if($flash != true) {
				echo '<img src="' . $this->request->webroot . 'img/erase.png">';
			}
			echo '</a></td>';			
			echo "</tr>";
		}		
		die;
	}

	public function addProductOrder() {

		$productsTable       = TableRegistry::get('products');
		$customersTable      = TableRegistry::get('customers');
		$ordersTable         = TableRegistry::get('orders');
		$orderProductsTable = TableRegistry::get('order_products');
		
		$order_products = $orderProductsTable->newEntity();
		
		$session             = $this->request->session();
		$flash_update = $session->read('flash_update');

		if(isset($flash_update)) {
			$session->delete('admin_cart');
			$session->delete('flash_update');
		}
		
		$user                = $this->Auth->user();
		$cart                = $session->read('admin_cart');
		$customer            = $customersTable->newEntity();

		if($this->request->is('POST')) {
			
			if(isset($cart)) {
				$data     = $this->request->data();
					
				$args['last_name']         = $data['last_name'];
				$args['first_name']         = $data['first_name'];
				$args['phone_number']         = $data['phone_number'];
				$args['email']         = $data['email'];
				$args['address']         = $data['address'];
				$args['created']         = Time::now();

				$customer       = $customersTable->patchEntity($customer, $args, ['validate' => 'Customer']);
				$customer_saved = $customersTable->save($customer);

				if($customer_saved) {
					$row_customer        = $customersTable->find('all')->last();
					$row_order           = $ordersTable->find('all')->last()->toArray();
					
					$orders              = $ordersTable->newEntity();
					$orders->customer_id = $row_customer->customer_id;
					$orders->created     = Time::now();
					$orders->user_id    =  $user['user_id'];

					if(count($row_order) > 0) {
						$orders->code_order = 'MSF50' . ( $row_order['order_id'] + 1 );
					} else {
						$orders->code_order = 'MSF5001';
					}

					$order_saved = $ordersTable->save($orders);
					if($order_saved) {

						foreach($cart as $key => $value) {
							$order_product             = $orderProductsTable->newEntity(); 
							$user_id             = $user['user_id']; 
							$order_product->product_id = $value['product_id'];
							$order_product->qty        = $value['qty'];
												
							$order_product->created    = Time::now();
							$order_product->order_id   = $order_saved->order_id;

							if($orderProductsTable->save($order_product)) {
								$products      = $productsTable->find('all')->where(['product_id' => $order_product->product_id])->first(); 
								
								$products->qty = $products->qty - $order_product->qty;
								$productsTable->save($products);
							}

						}
						
						$this->Flash->success('Order success !');
						$this->redirect(['controller' => 'orders', 'action' => 'listOrderDoneAtShop']);

					}
				}

				$order_product          = $orderProductsTable->patchEntity($order_product, $data);
				$order_product->created = Time::now();
			} else {
				$this->Flash->error('Cart shopping empty !');
			}
		}

		$dropdown_product = TableRegistry::get('products')->find('list', [
													'keyField'   => 'product_id',
													'valueField' => 'tam',
												])
												->where(['qty > ' => 0])
												->select(['product_id', 'tam' => 'CONCAT(name_product, "  --  ", price, ".000 VND", " --- Qty: ", qty )'])
												->toArray();
		
		if(count($cart) > 0) {
			foreach($cart as $key => $value) {
				$row_product          = $productsTable->find('all')->where(['product_id' => $value['product_id']])->first();
				$row_product->qty     = $value['qty'];
				$list_product_order[] = $row_product;
			}
			$this->set('list_product_order', $list_product_order);									
		}	

		$this->set('customer', $customer);
		$this->set("dropdown_product", $dropdown_product);
		$this->set('order', $order_products);
		
	}

	public function updateOrder($order_id) {
		$ordersTable        = TableRegistry::get('orders');
		$productsTable      = TableRegistry::get('products');
		$orderProductsTable = TableRegistry::get('order_products');

		$session = $this->request->session();

		$rs_order_products = $orderProductsTable->find('all')->where(['order_id' => $order_id])->toArray();
		$dropdown_product  = $productsTable->find('list', [
															'keyField'   => 'product_id',
															'valueField' => 'value'
														])
														->select([
															'product_id', 'value' => 'CONCAT(name_product, " --- Qty: ", qty, " --- ", price, ".000 VND" )'
														])
														->where(['qty >' => 0])
														->toArray();

		if($this->request->is('POST')) {

			$cart = $session->read('admin_cart');
			// debug($cart); die;

			$where = ['order_id' => $order_id];
			$orderProductsTable->deleteAll($where);

			if(count($rs_order_products) > 0) {
				foreach($rs_order_products as $key => $value) {
					$row_product = $productsTable->find('all')->where(['product_id' => $value['product_id']])->first();
					$row_product->qty = $row_product->qty + $value['qty'];

					$productsTable->save($row_product);
				}	
			}

			if(count($cart) > 0) {
				foreach($cart as $key => $value) {

					$orderProducts             = $orderProductsTable->newEntity(); 
					$orderProducts->product_id = $value['product_id'];
					$orderProducts->qty        =  $value['qty'];									
					$orderProducts->created    = Time::now();
					$orderProducts->order_id   = $order_id;

					if($orderProductsTable->save($orderProducts)) {
						$products      = $productsTable->find('all')->where(['product_id' => $orderProducts->product_id])->first(); 
						
						$products->qty = $products->qty - $orderProducts->qty;
						$productsTable->save($products);
					}

				}	
			}
			

			$this->Flash->success('Order success !');
			$this->redirect(['controller' => 'orders', 'action' => 'listOrderDoneAtShop']);

		} else {

				foreach($rs_order_products as $key => $value) {
					$cart[] = ['product_id' => $value['product_id'], 'qty' => $value['qty']];
				}

				if(count($cart) > 0) {
					foreach($cart as $key => $value) {
						$row_product = $productsTable->find('all')->where(['product_id' => $value['product_id']])->first();
						$row_product->qty = $value['qty'];
						$list_product_order[] = $row_product;
					}
				}
				
				$this->set('list_product_order', $list_product_order);		

			// $session->delete('admin_cart');
			$session->write('flash_update', true);
			$session->write('admin_cart', $cart);
		}

		$this->set('dropdown_product', $dropdown_product);													
	}

	public function deleteOrder() {
		$id = $this->request->params['pass'][0];
		if(!isset($id)) {
			$this->redirect(['controller' => 'orders', 'action' => 'delete']);
		} else {
			$ordersTable = TableRegistry::get('orders');
			$order = $ordersTable->find('all')->where(['order_id' => $id])->first();
			// $order = $ordersTable->newEntity($order);
			if($ordersTable->delete($order)) {
				$this->redirect(['controller' => 'orders', 'action' => 'listOrder']);
				$this->Flash->success(__('Delete order ' . $order->order_id . ' success '));
			} else {
				$this->redirect(['controller' => 'orders', 'action' => 'listOrder']);
				$this->Flash->error(__("Can't delete order this !"));
			}
		}
	}

}