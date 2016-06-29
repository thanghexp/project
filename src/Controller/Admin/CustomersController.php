<?php 

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class customersController extends AppController {

	public $paginate = [
						'limit' => '5',
						'order' => ['customer.id' => 'asc']
					];

	public function initialize() {
		parent::initialize();
	}

	public function listCustomer() 
	{
		$customersTable = TableRegistry::get('customers');
		$customers_result = $customersTable->find('all');
		
		if(!$customers_result) {
			$this->Flash->error(__('Database customer table empty !'));
		}

		$this->set('customers', $this->paginate($customers_result));
		$this->set('title', 'View list customer');
	}

	public function addCustomer() 
	{
		$customersTable = TableRegistry::get('customers');
		$customer = $customersTable->newEntity();

		if($this->request->is('POST')) {

			$data = $this->request->data;
			$customer = $customersTable->patchEntity($customer, $data, ['validate' => 'Customer']);
			$customer->created = Time::now();
			
			if(!$customer->errors()) {
				if($customersTable->save($customer)) {
					$this->redirect(['controller' => 'customers', 'action' => 'listCustomer']);
					$this->Flash->success(__('Create new customer !'));
				} else {
					$this->Flash->error(__('Error data !'));
				}
			}

		}

		$this->set('customer', $customer);
		$this->set('title', 'Add new a customer !');
	}

	public function updateCustomer()
	{	
		$id = $this->request->params['pass']['0'];
		if(!$id) {

			$this->redirect(['controller' => 'customers', 'action' => 'listCustomer']);
		} else {

			$customersTable = TableRegistry::get('customers');
			$customer = $customersTable->newEntity();

			if($this->request->is('POST')) {
				$data = $this->request->data;
				$customer = $customersTable->patchEntity($customer, $data, ['validate' => 'customer']);
				$customer->customer_id = $id;
				$customer->updated = Time::now();

				if($customersTable->save($customer)) {
					$this->redirect(['controller' => 'customers', 'action' => 'listCustomer']);
					$this->Flash->success(__('Update recored ' . $id . ' customer !'));
				} else {
					$this->Flash->error(__('Error data !'));
				}

			}

			$row_customer = $customersTable->find('all')->where(['customer_id' => $id])->first();
			$this->set('row_customer', $row_customer);
			$this->set('customer', $customer);
			$this->set('title', 'Update customer');
		}

	}

	public function deleteCustomer() 
	{	
		$id = $this->request->params['pass'][0];	
		if(!$id) {
			$this->redirect(['controller' => 'customers', 'action' => 'listCustomer']);
		} else {
			$customersTable = TableRegistry::get('customers');
			$customer = $customersTable->find('all')->where(['customer_id' => $id])->first();
			
			if($customersTable->delete($customer)) {
				$this->redirect(['controller' => 'customers', 'action' => 'listCustomer']);
				$this->Flash->success(__('Delete customer success !'));
			} else {
				$this->Flash->error(__('Error data !'));
			}

		}

	}

}
