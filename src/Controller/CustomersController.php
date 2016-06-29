<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class CustomersController extends AppController {

	public function signUp() 
	{
		$this->isAuthorized();

		$customersTable = TableRegistry::get('customers');
		$customer = $customersTable->newEntity();

		if($this->request->is("POST")) {
				
			$data = $this->request->data;
			$customer = $customersTable->patchEntity($customer, $data);
			$customer->password = sha1($customer->password);

			if(isset($customer)) {
				if($customersTable->save($customer)) {
					$this->redirect(['controller' => 'home', 'action' => 'index']);
					$this->Flash->success(__('Create new customer success'));
				} else {
					$this->Flash->error(__(" Errors "));
				}
			}

		}

		$this->set(compact('customer', $customer));
		$this->set('title', 'Add new a customer');
	}

	public function login() 
	{
		$this->isAuthorized();

		$customersTable = TableRegistry::get('customers');
		$customer = $customersTable->newEntity();

		if($this->request->is("POST")) {
				
			$data     = $this->request->data;
			$user     = $customersTable->find('all')->where(['username' => $data['username']])->first();
			$customer = $customersTable->patchEntity($customer, $data); 

			if(isset($customer) && isset($user)) {

				$customer->password = sha1($customer->password);
				if($customer->password == $user->password) {
					
					$session = $this->request->session();
					$session->write('authentication', $user);
					
					$flash = $session->read('flash');

					if($flash) {
						return $this->redirect($flash);
					}

					$this->redirect(['controller' => 'home', 'action' => 'index']);
					return $this->Flash->success(__(' Login success'));
					
				} else {
					$this->Flash->error(__(" Password not correct "));
				}
			} else {
				$this->Flash->error(__(" Username not found "));
			}

		}

		$this->set(compact('customer', $customer));
		$this->set('title', 'Add new a customer');
	}

	public function updateCustomer()
	{
		
		$id = $this->request->params['pass']['0'];
		if(!isset($id)) {
			$this->redirect(['controller' => 'customers', 'action' => 'listcustomer']);
			$this->Flash->error(__('Not Found customer !'));
		} else {

			$customersTable = TableRegistry::get('customers');
			$customer = $customersTable->newEntity();

			if($this->request->is("POST")) {
				
				$data = $this->request->data;
				$customer = $customersTable->patchEntity($customer, $data);
				$customer->customer_id = $id;
				$customer->updated = Time::now();

				if(isset($customer)) {
					if($customersTable->save($customer)) {
						$this->redirect(['controller' => 'customers', 'action' => 'listcustomer']);
						$this->Flash->success(__('Create new a customer success'));
					} else {
						$this->Flash->error(__(" Errors "));
					}
				}

			}
		}
		$category_dropdown = TableRegistry::get('categorys')->find('list', ['fieldList' => 'category_id', 'valueField' => 'name_category']);
		$row_customer = $customersTable->find('all')->where(array('customer_id' => $id))->first();
		$this->set('row_customer', $row_customer );
		$this->set('category_dropdown', $category_dropdown);
		$this->set('customer', $customer);
		$this->set('title', 'Update info a customer');
	}


	public function listCustomer() 
	{
		$customersTable  = TableRegistry::get('customers');
		$result_customer = $customersTable->find('all')
											->select([
												'customer_id', 'name_customer', 
												'categorys.name_category' , 'customers.created',
												'price', 'customers.updated'
											])
											->contain('categorys');

		if(!$result_customer) {
			$this->Flash->error(__('Database customers table empty'));
		}

		$this->set('customers', $this->paginate($result_customer));
		$this->set('title', 'List view a customer !');
	}

	public function logout() {
		$session = $this->request->session();
		$session->delete('authentication');
		$session->delete('my_cart');
		return $this->redirect(['controller' => 'Home', 'action' => 'index']);
	}

	public function isAuthorized() {
		if($this->request->session()->read('authentication')) {
			$this->Flash->error(__('You logined !'));
			return $this->redirect(['controller' => 'home', 'action' => 'index']);
		}
	}



}