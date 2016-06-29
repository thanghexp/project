<?php 

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class DesksController extends AppController {

	public $paginate = [
						'limit' => '5',
						'order' => ['desk.id' => 'asc']
					];

	public function initialize() {
		parent::initialize();
	}

	public function listDesk() 
	{
		$desksTable = TableRegistry::get('desks');
		$desks_result = $desksTable->find('all');

		if(!$desks_result) {
			$this->Flash->error(__('Database desk table empty !'));
		}

		$this->set('desks', $this->paginate($desks_result));
		$this->set('title', 'List view table');
	}

	public function addDesk() 
	{
		$desksTable = TableRegistry::get('desks');
		$desk = $desksTable->newEntity();

		if($this->request->is('POST')) {

			$data = $this->request->data;
			$desk = $desksTable->patchEntity($desk, $data);
			$desk->created = Time::now();

			if($desksTable->save($desk)) {
				$this->redirect(['controller' => 'desks', 'action' => 'listDesk']);
				$this->Flash->success(__('Create new desk !'));
			} else {
				$this->Flash->error(__('Error data !'));
			}

		}

		$this->set('desk', $desk);
		$this->set('title', 'Add new a desk !');
	}

	public function updateDesk()
	{	
		$id = $this->request->params['pass']['0'];
		if(!$id) {

			$this->redirect(['controller' => 'desks', 'action' => 'listDesk']);
		} else {

			$desksTable = TableRegistry::get('desks');
			$desk = $desksTable->newEntity();

			if($this->request->is('POST')) {
				$data = $this->request->data;
				$desk = $desksTable->patchEntity($desk, $data);
				$desk->desk_id = $id;
				$desk->updated = Time::now();

				if($desksTable->save($desk)) {
					$this->redirect(['controller' => 'desks', 'action' => 'listDesk']);
					$this->Flash->success(__('Update recored ' . $id . ' desk !'));
				} else {
					$this->Flash->error(__('Error data !'));
				}

			}

			$row_desk = $desksTable->find('all')->where(['desk_id' => $id])->first();

			$this->set('row_desk', $row_desk);
			$this->set('desk', $desk);
			$this->set('title', 'Update info for desk !');
		}

	}

	public function deleteDesk() 
	{	
		$id = $this->request->params['pass'][0];	
		if(!$id) {
			$this->redirect(['controller' => 'desks', 'action' => 'listdesk']);
		} else {
			$desksTable = TableRegistry::get('desks');
			$desk = $desksTable->find('all')->where(['desk_id' => $id])->first();
			
			if($desksTable->delete($desk)) {
				$this->redirect(['controller' => 'desks', 'action' => 'listDesk']);
				$this->Flash->success(__('Delete desk success !'));
			} else {
				$this->Flash->error(__('Error data !'));
			}
		}

	}

}
