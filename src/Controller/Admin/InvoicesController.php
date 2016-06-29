<?php 
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class InvoicesController extends AppController {

	public function listInvoice($code_order = null) 
	{
		$orderProductsTable = TableRegistry::get('order_products');
		$ordersTable = TableRegistry::get('orders');
		$invoicesTable = TableRegistry::get('invoices');

		$invoices = $invoicesTable->find('all')->contain(['orders'])->toArray();
		$invoice_total = $invoicesTable->find('all')
									 ->select(['sum_total_money' => 'SUM(total_money)'])
									 ->contain(['orders'])->first();
		
		$this->set('invoice_total', $invoice_total);
		$this->set('invoices', $invoices);
		$this->set('title', 'List view a invoice ' . (isset($code_order) ? 'have code order ID : ' . $code_order : '') . ' ! ');

	}

	public function deleteInvoice()
	{
		$id = $this->request->params['pass']['0'];

		if(!$id) {
			$this->redirect(['controller' => 'invoices', 'action' => 'listInvoice']);
			$this->Flash->error(__('Not Found invoice !'));
		} else {
			$invoicesTable = TableRegistry::get('invoices');
			$row_invoice   = $invoicesTable->find('all')->where(array('invoice_id' => $id))->first();

			if($invoicesTable->delete($row_invoice)) {				
				$this->Flash->success("Delete invoices" . $id . " success !");
			} else {
				$this->Flash->error("Errors");
			}

			$this->redirect(['controller' => 'invoices', 'action' => 'listInvoice']);
		}

	}

}