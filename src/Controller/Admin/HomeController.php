<?php 

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class HomeController extends AppController {
	public $paginator = [
						'limit' => 5
					];

	public function initialize() {
		parent::initialize();
	}

	public function index() {
	}

	public function dashboard() {

		$orderProductsTable = TableRegistry::get('order_products');
		$orderProducts = $orderProductsTable->find('all');

		$list_date = $orderProductsTable->find('list', [
															'keyField'   => 'date',
															'valueField' => 'date'
														])
													->select(['date' => 'DATE(orders.created)'])
													->group('order_id');

		$total_order_paid = TableRegistry::get('orders')->find('all')
														 ->select([
																'count' => 'COUNT(order_id)'
														 	])
														 ->where(['status' => 3])
														 ->first();

		$total_order = TableRegistry::get('orders')->find('all')
													 ->select([
															'count' => 'COUNT(order_id)'
													 	])
													 ->first();

		$total_customer = TableRegistry::get('customers')->find('all')
														 ->select([
																'count' => 'COUNT(customer_id)'
														 	])
														 ->first();

		$total_customer_status = TableRegistry::get('customers')->find('all')
																 ->select([
																		'count' => 'COUNT(customer_id)'
																 	])
																 // ->where(['orders.status' => '0'])
																 // ->contain(['orders'])
																 ->first();												 

		$total_money_paid = TableRegistry::get('invoices')->find('all')
														 ->select([
																	'sum' => 'SUM(total_money)'
															 ])
														 ->contain(['orders'])
														 ->first();		 

		$total_money = $orderProductsTable->find('all')
											 ->select([
														'sum' => 'SUM(order_products.qty * products.price)'
												 ])
											 ->contain(['products', 'orders'])->first();

		$result_column1_money = TableRegistry::get('invoices')->find('all')
															 ->select([
																	'month'       => 'MONTHNAME(orders.created)',
																	'count_order' => 'COUNT(orders.order_id)',
																	'total_money' => 'SUM(total_money)'
															 ])
															 ->where([
															 		'DATEDIFF(invoices.created , now()) <=' => '365', 
															 		'orders.status' => 3
															 	])
															 ->group('MONTH(invoices.created)')
															 ->contain(['orders'])->toArray();

		$data_column1_total = TableRegistry::get('invoices')->find('all')
													 ->select([
															'month'       => 'MONTHNAME(invoices.created)',
															'count_order' => 'COUNT(orders.order_id)',
															'total_money' => 'SUM(total_money)',
															'orders.code_order'
													 ])
													 ->where([
													 		'DATEDIFF(invoices.created , now()) <=' => '365', 
													 		'orders.status' => 3,
													 		// 'SUBSTRING(orders.code_order, 3, 1)' => 'F'
													 		'orders.code_order LIKE' => '%F%'
													 	])
													 ->group('MONTH(invoices.created)')
													 ->contain(['orders'])->toArray();	
		
		$data_column2_total = TableRegistry::get('invoices')->find('all')
													 ->select([
															'month'       => 'MONTHNAME(invoices.created)',
															'count_order' => 'COUNT(orders.order_id)',
															'total_money' => 'SUM(total_money)',
															'orders.code_order'
													 ])
													 ->where([
													 		'DATEDIFF(invoices.created , now()) <=' => '365', 
													 		'orders.status' => 3,
													 		// 'SUBSTRING(orders.code_order, 3, 1)' => 'F'
													 		'orders.code_order LIKE' => '%O%'
													 	])
													 ->group('MONTH(invoices.created)')
													 ->contain([ 'orders'])->toArray();	

		#view data_column2_total & data_column1_total
		if(count($data_column1_total) > count($data_column2_total)) {
			if(count($data_column1_total) > 0) {
				foreach($data_column1_total as $invoice) {
					$labels[]            = $invoice->month;
					$count_order[]       = $invoice->count_order;
					$data_total1_money[] = $invoice->total_money; 
				}		
			}

			if(count($data_column2_total) > 0) {				
				foreach($data_column2_total as $invoice) {
					$rs = array_search($invoice->month, $labels);
					if($rs) {
						$count_order2[$rs]      = $invoice->count_order;
						$data_total2_money[$rs] = $invoice->total_money;
					} 
				}

				foreach($labels as $key => $value) {
					if(!isset($data_total2_money[$key])) {
						$data_total2_money[$key] = 0;
						
					}
					if(!isset($count_order2[$key])) {
						$count_order2[$key] =0;
					} 
				}
				
				sort($count_order2);
				sort($data_total2_money);
			}
		} else {
			if(count($data_column2_total) > 0) {
				foreach($data_column2_total as $invoice) {
					$labels[]           = $invoice->month;
					$count_order[]      = $invoice->count_order;
					$data_total2_money[] = $invoice->total_money; 
				}		
			}

			if(count($data_column1_total) > 0) {
				foreach($data_column1_total as $invoice) {
					if($value == $invoice->month) {
						$count_order1[$key]      = $invoice->count_order;
						$data_total1_money[$key] = $invoice->total_money;
					} else {
						$count_order1[$key] = 0;
						$data_total1_money[$key] = 0;
					}
				}

				foreach($labels as $key => $value) {
					if(!isset($data_total1_money[$key])) {
						$data_total1_money[$key] = 0;
					}

					if(!isset($count_order[$key])) {
						$count_order[$key] =0;
					} 
				}

				sort($data_total1_money);
				sort($count_order);
			}
		}
		


		$this->set('labels', isset($labels) ?  json_encode($labels) : '');
		$this->set('count_order', isset($count_order) ? json_encode($count_order) : ''); 
		$this->set('count_order2', isset($count_order2) ? json_encode($count_order2) : ''); 
		$this->set('data_column1_total', isset($data_total1_money) ?  json_encode($data_total1_money) : 0);
		$this->set('data_column2_total', isset($data_total2_money) ? json_encode($data_total2_money) : 0);


		$result_invoice = TableRegistry::get('order_products')->find('all')
															->select([
																	'money' => 'SUM(products.price * order_products.qty)',
																	'date' =>'DATE(orders.created)','orders.code_order',
																	'orders.status', 'orders.created',
																	'order_products.qty', 'orders.order_id'
															])
															->group('orders.order_id')
															->where(['DATE(orders.created) = DATE(now())'])
															->contain(['orders', 'products'])
															->toArray();
		// debug($result_invoice); die;

		// debug($result_invoice); die;										
		// Data to chartjs
		
		$this->set('total_money', isset($total_money->sum) ? $total_money->sum : null);
		$this->set('total_money_paid', isset($total_money_paid->sum) ? $total_money_paid->sum : null);
		$this->set('total_customer', $total_customer->count);
		$this->set('total_customer_status', $total_customer_status->count);
		$this->set('total_order', $total_order->count);
		$this->set('total_order_paid', isset($total_order_paid->count) ? $total_order_paid->count : 0 );

		$this->set('orderProducts', $result_invoice);
		$this->set('result_data_invoice', $result_invoice);
		$this->set('list_date', $list_date);
	}

	public function dataToDate() {
		$orderProductsTable = TableRegistry::get('orders');
		$orderProducts = $orderProductsTable->find('all');

		$data = $this->request->data();

		$list_date = $orderProductsTable->find('list', [
											'keyField'   => 'date',
											'valueField' => 'date'
										])
									->select(['date' => 'DATE(orders.created)'])
									->where(['created >' => $data['from_date']])
									->group('order_id');
		
		echo "<select name='toDate' id='toDate'>";
		foreach($list_date as $key => $value) {
			echo '<option value="'. $key .'" >'.$value . '</option>';
		}
		echo "</select>";

		die;
	}

}