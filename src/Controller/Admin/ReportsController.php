<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class  ReportsController extends AppController {

	public function initialize() {
		parent::initialize();
	}

	public function productsQtySale() {

		if($this->request->is("POST")) {
			$invoicesTable      = TableRegistry::get('invoices');
			$orderProductsTable = TableRegistry::get('order_products');
			$data               = $this->request->data();
			
			$data['start_date'] = strtotime($data['start_date']); 
			$data['start_date'] = date('Y-m-d',$data['start_date']);
			
			$data['end_date']   = strtotime($data['end_date']);
			$data['end_date']   = date('Y-m-d', $data['end_date']);

			if($data['filter'] == 0) {
				$result_table1 = $orderProductsTable->find('all')
											->select([
														'month'           => 'MONTHNAME(order_products.created)',
														'total_qty_order' => 'SUM(order_products.qty)',
														'products.name_product', 
												])
											->where([
													'DATE(order_products.created) >=' => $data['start_date'],
													'DATE(order_products.created) <=' => isset($data['end_date']) ? $data['end_date'] : 'now()',
													'orders.status' => 3
												])
											->group([ 'order_products.product_id'])
											->contain(['products', 'orders'])->toArray();

				foreach($result_table1 as $invoice) {
					$labels[]     = $invoice->product->name_product;
					$data_chart[] = $invoice->total_qty_order;
				}

				$title_table1     = 'Qty product sale ';
				$title_table      = 'Qty';
				$title_table_main = 'Product';
				$report           = '#Report products sale monthly';
				$unit_chart1      = 'Qty order';

			} else if($data['filter'] == 1) {

				$result_table1 = $invoicesTable->find('all')
											->select([
												'created'     => 'DATE(invoices.created)',
												'total_money' => 'SUM(total_money)',
												'month'       => 'MONTHNAME(invoices.created)' , 
											])
											->where([
													'DATE(invoices.created) >=' => $data['start_date'],
													'DATE(invoices.created) <=' => $data['end_date'],
													'orders.code_order LIKE' => '%O%',						
													'DATEDIFF(invoices.created , now()) <=' => '365',						
												])
											->contain(['orders'])
											->group(['DATE(invoices.created)'])
											->toArray();

				$result_table2 = $invoicesTable->find('all')
											->select([
												'created'     => 'DATE(invoices.created)',
												'total_money' => 'SUM(total_money)',
												'month'       => 'MONTHNAME(invoices.created)' , 
											])
											->where([
													'DATE(invoices.created) >=' => $data['start_date'],
													'DATE(invoices.created) <=' => $data['end_date'],					
													'orders.code_order LIKE' => '%F%',					
													'DATEDIFF(invoices.created , now()) <=' => '365',			
												])
											->contain(['orders'])
											->group(['DATE(invoices.created)'])
											->toArray();

				$result_invoice_online = $invoicesTable->find('all')
														->select([
															'total_money' => 'SUM(total_money)',
															'month'       => 'MONTHNAME(invoices.created)' , 
														])
														->where([
																'DATE(invoices.created) >=' => $data['start_date'],
																'DATE(invoices.created) <=' => $data['end_date'],
																'orders.code_order LIKE' => '%O%', 
																'DATEDIFF(invoices.created , now()) <=' => '365',
															])
														->group(['MONTHNAME(invoices.created)'])
														->contain(['orders'])
														->toArray();

				
				$result_invoice_offline = $invoicesTable->find('all')
														->select([
															'total_money' => 'SUM(total_money)',
															'month'       => 'MONTHNAME(invoices.created)' , 
														])
														->where([
																'DATE(invoices.created) >=' => $data['start_date'],
																'DATE(invoices.created) <=' => $data['end_date'],
																'orders.code_order LIKE' => '%F%',
																'DATEDIFF(invoices.created , now()) <=' => '365',
															])
														->contain(['orders'])
														->group(['MONTHNAME(invoices.created)'])
														->toArray();

				if(count($result_invoice_online) > count($result_invoice_offline)) {
					foreach($result_invoice_online as $invoice) {
						$labels[]     = $invoice->month;
						$data_chart[] = $invoice->total_money;
					}

					foreach($labels as $key => $value) {
						foreach($result_invoice_offline as $invoice) {
							if($value == $invoice->month) {
								$data_chart2[$key] = $value['total_money'];
							} else {
								$data_chart2[$key] = 0;
							}
						}
					}

					foreach($data_chart as $key => $value) {
						if(!isset($data_chart2[$key])) {
							$data_chart2[$key] = (float) 0;
						}
					}
					sort($data_chart2);

				} else {
					foreach($result_invoice_offline as $invoice) {
						$labels[] = $invoice->month;
						$data_chart2[] = $invoice->total_money;
					}

					foreach($result_invoice_online as $invoice) {
						$rs = array_search($invoice->month, $labels);
						if(isset($rs)) {
							$data_chart[$rs] = $invoice->total_money;
						} else {
							$data_chart[$rs] = 0;
						}
					}

					foreach($data_chart2 as $key => $value) {
						if(!isset($data_chart[$key])) {
							$data_chart[$key] = (float) 0;
						}
					}
					sort($data_chart);

				}
				

				$title_table1 = '#Total money of order online';
				$title_table2 = '#Total money of order offline';
				$unit_chart1 = 'online /.ooo VND';
				$unit_chart2 = 'offline /.ooo VND';
				$title_table = 'Total money';
				$title_table_main = 'Date';
				$report = '#Report total money sale monthly';
				
			} 

			// debug($data_chart); die;
			// debug($data_chart2); die;



			$this->set('labels', isset($labels) ? json_encode($labels) : null);
			$this->set('data_chart', isset($data_chart) ? json_encode($data_chart) : 0);
			$this->set('data_chart2', isset($data_chart2) ? json_encode($data_chart2) : 0);

			$this->set('unit_chart1', isset($unit_chart1) ? $unit_chart1 : '');
			$this->set('unit_chart2', isset($unit_chart2) ? $unit_chart2 : '');
			$this->set('report', $report);
			$this->set('filter', $data['filter']);
			$this->set('title_table_main', $title_table_main);
			$this->set('title_table', $title_table); 
			$this->set('result_table1', isset($result_table1) ? $result_table1 : null);
			$this->set('result_table2', isset($result_table2) ? $result_table2 : null);
			$this->set('title_table1', isset($title_table1) ? $title_table1 : null);
			$this->set('title_table2', isset($title_table2) ? $title_table2 : null);
		}

		$dropdown_filter = ['0' => 'Product', '1' => 'Total invoice'];
		$this->set('dropdown_filter', $dropdown_filter);
	}

}