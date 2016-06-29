<?php  

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class OrderProductsController extends AppController {

	public function initialized() {
		parent::__construct();
	}

	public function listOrderProduct($code_order = null) 
	{
		$orderProductsTable = TableRegistry::get('order_products');
		$productsTable      = TableRegistry::get('products');
		$ordersTable        = TableRegistry::get('orders');

		$row_order = $ordersTable->find('all')
									    ->where(['code_order' => $code_order])
									    ->first();

		if($this->request->is('POST')) {
			$data = $this->request->data();

			if(isset($data['change'])) {
				if($row_order['status'] == 3) {
					$this->Flash->error(__('This order status is paid should not be change !'));
				} else {
					$user               = $this->Auth->user();
					$row_order->updated = Time::now();
					$row_order->status  = $data['status'];
					$row_order->user_id = $user['user_id'];

					if($ordersTable->save($row_order)) {
						$this->Flash->success(__('Update status order success !'));
					}

				}
			} else {
				if(isset($data['add'])) {
					$row_product = $productsTable->find('all')->where(['product_id' => $data['product_id']])->first();
					$row_product->qty -= $data['qty'];

					if($productsTable->save($row_product)) {
						$order_products             = $orderProductsTable->newEntity();
						$order_products->qty        = $data['qty'];
						$order_products->product_id = $data['product_id'];
						$order_products->order_id   = $row_order->order_id;

						if($orderProductsTable->save($order_products)) {
							$this->Flash->success('Add new order success !');
						}	
					}

				} else {

					if(isset($data['update'])) {
						foreach($data['qty_order'] as $key => $value) {
							if($data['check'][$key] == 1) {
								$order_products      = $orderProductsTable->find('all')
																		  ->where([
																		  		'order_id' => $row_order->order_id,
																		  		'product_id' => $key
																		  	])
																		  ->first();

								$row_product = $productsTable->find('all')
														     ->where(['product_id' => $data['product_id']])				
														     ->first();
								$row_product->qty = ($row_product->qty + $order_products->qty) -  $value;
								// echo $row_product->qty; die;
								$productsTable->save($row_product);

								if($productsTable->save($row_product)) {
									$order_products->qty = $value;
									$orderProductsTable->save($order_products);
								}
							}
							 
						}
					}

					$this->Flash->success(__('Update success order !'));
				}
			}

			return $this->redirect('/admin/orderProducts/listOrderProduct/' . $code_order);
		}

		if(isset($code_order)) {
			$result_order_product = $orderProductsTable->find('all')
														->select([
																'products.name_product', 
																 'products.price', 'order_id',
																'qty', 'orders.order_id', 'product_id'
														])
														->where(['orders.code_order' => $code_order])
														->contain(['orders', 'products'])->toArray();
		} else {
			$result_order_product = $orderProductsTable->find('all')
														->select([
																 'products.name_product', 'product_id',
																 'products.price', 'order_id',
																'qty', 'orders.order_id'
														])
														->contain(['orders', 'products'])->toArray();
		}
		
		if(!$result_order_product) {
			$this->Flash->error(__('Database order products table empty'));
		}

		$info = $ordersTable->find('all')
						   ->select(['full_name' => 'CONCAT(customers.last_name, " ", customers.first_name )',
									'customers.address', 'customers.phone_number', 'orders.order_id', 
									'customers.email', 'orders.code_order', 'orders.created', 'orders.updated'])
						  ->contain(['customers'])
						  ->where(['code_order' => $code_order])->first();


		foreach($result_order_product as $key => $value) {
			$array_product_id[]  = $value['product_id'];
		}

		$dropdown_product = TableRegistry::get('products')->find('list', [
																	'keyField'   => 'product_id',
																	'valueField' => 'value'
															])
															->select([
																	'product_id', 
																	'value' => 'CONCAT(name_product, " --- Qty: ", qty, " --- ", price, ".000 VND" )'])
															->where(['qty >' => 0, 'product_id NOT IN' => $array_product_id])
															->toArray();


		$dropdown_status = ['0' => 'Ordered', '1' => 'Approve', '2' => 'Transfer', '3' => 'Paid', '4' => 'Fail'];

		$this->set('dropdown_product', $dropdown_product);
		$this->set('row_order', $row_order);
		$this->set('info', $info);
		$this->set('dropdown_status', $dropdown_status);
		$this->set('result_order_product', $result_order_product);
		$this->set('title', 'View list order ' . (isset($code_order) ? 'have code order ID : ' . $code_order : '') . ' ! ');
	}

	public function addOrderProduct() 
	{
		$orderProductsTable = TableRegistry::get('invoices');
		$invoices = $orderProductsTable->newEntity();

		if($this->request->is('POST')) {
			$user              = $this->Auth->user();
			$data              = $this->request->data;
			$invoices          = $orderProductsTable->patchEntity($invoices, $data);
			$invoices->updated = Time::now();
			$invoices->status  = 1;
			$invoices->user_id = $user['user_id'];

			$productsTable = TableRegistry::get('products');
			$row_product = $productsTable->find('all')->where(['product_id' => $data['product_id']])->first();

			if($row_product->qty >= $data['qty']) {
				$row_product->qty = $row_product->qty - $data['qty'];
				$productsTable->save($row_product);

				if(!$invoices->errors()) {
					if($orderProductsTable->save($invoices)) {
						$this->Flash->success(__('Create new invoice products !'));
						return $this->redirect(['controller' => 'invoices', 'action' => 'listInvoice']);
					} else {
						$this->Flash->error(__('Error data !'));
					}
				}

			} else {
				$this->Flash->error(__('This Product only have '. $row_product->qty . ' !'));
			}

		} 

		$dropdown_orderid = TableRegistry::get('orders')->find('list', [
														'keyField'   => 'order_id',
														'valueField' => 'order_id'
													]);

		$dropdown_product = TableRegistry::get('products')->find('list', [
													'keyField'   => 'product_id',
													'valueField' => 'tam',
												])
												->select(['product_id', 'tam' => 'CONCAT(name_product, "  --  ", price, ".000 VND")']);
												
		$this->set('dropdown_orderid', $dropdown_orderid);
		$this->set("dropdown_product", $dropdown_product);
		$this->set('invoices', $invoices);
	}

	public function updateOrderProduct()
	{
		$id            = $this->request->params['pass']['0'];
		$orderProductsTable = TableRegistry::get('invoices');
		$row_invoice   = $orderProductsTable->find('all')->where(array('order_product_id' => $id))->first();

		if(!isset($id)) {
			$this->redirect(['controller' => 'invoices', 'action' => 'listInvoice']);
			$this->Flash->error(__('Not Found invoice !'));
		} else {		
			$invoice       = $orderProductsTable->newEntity();

			if($this->request->is("POST")) {
				
				$data                = $this->request->data;
				$invoice             = $orderProductsTable->patchEntity($invoice, $data);
				$invoice->order_product_id = $id;
				$invoice->updated    = Time::now();

				if($data['qty'] == 0) {
					if($orderProductsTable->delete($row_invoice)) {				
						$this->Flash->success("Delete invoices" . $id . " success !");
						return $this->redirect(['controller' => 'invoices', 'action' => 'listInvoice']);
					} else {
						$this->Flash->error("Errors");
					}
				}

				$productsTable = TableRegistry::get('products');
				$product = $productsTable->find('all')->where(['product_id' => $data['product_id']])->first();
				$dem = $product->qty + $row_invoice->qty;

				if($dem >= $data['qty']) {
					$product->qty = $dem - $data['qty'];
					$productsTable->save($product);

					if(isset($invoice)) {
						if($orderProductsTable->save($invoice)) {
							$this->Flash->success(__('Update a invoice success'));
							return $this->redirect(['controller' => 'invoices', 'action' => 'listInvoice']);
						} else {
							$this->Flash->error(__(" Errors "));
						}
					}

				} else {
					$this->Flash->error(__('This Product only have qty :' . $product->qty . ' !'));
				}

			}
			$dropdown_customer = TableRegistry::get('orders')->find('list', [
													'keyField'   => 'order_id', 
													'valueField' => 'full_name'
												])
												->select(['order_id', 'full_name' => 'CONCAT(customers.last_name, " ", customers.first_name, " ---     (Adress:", customers.address, " --- Phone number:" , customers.phone_number, ")")'])
												->contain(['customers']);

			$dropdown_product = TableRegistry::get('products')->find('list', [
														'keyField'   => 'product_id',
														'valueField' => 'tam',
													])
													->select(['product_id', 'tam' => 'CONCAT(name_product, "  --  ", price, "VND")']);
													 
			$this->set('dropdown_customer', $dropdown_customer);
			$this->set("dropdown_product", $dropdown_product);
			$this->set('row_invoice', $row_invoice );
			$this->set('invoice', $invoice);
			$this->set('title', 'Update info a invoice');
		}
		
	}

	public function deleteOrderProduct()
	{
		$order_id   = $this->request->params['pass']['0'];
		$product_id = $this->request->params['pass']['1'];

		$row_order = TableRegistry::get('orders')->find('all')->where(['order_id' => $order_id])->first();
		$row_product = TableRegistry::get('products')->find('all')->where(['product_id' => $product_id])->first();

		if(!$order_id) {
			$this->redirect('Orders/listOrder');
			$this->Flash->error(__('Not Found order_products !'));
		} else {
			$orderProductsTable = TableRegistry::get('order_products');
			$row_order_product   = $orderProductsTable->find('all')
												->where(array('order_id' => $order_id, 'product_id' => $product_id))
												->first();

			$row_product->qty = $row_product->qty + $row_order_product->qty;
			TableRegistry::get('products')->save($row_product); 

			if($orderProductsTable->delete($row_order_product)) {				
				$this->Flash->success("Delete order product" . $product_id . " success !");
			} else {
				$this->Flash->error("Errors");
			}

			$this->redirect('/admin/orderProducts/listOrderProduct/' . $row_order->code_order);
		}

	}

}