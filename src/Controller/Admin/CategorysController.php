<?php 

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class CategorysController extends AppController {

	public $paginate = [
						'limit' => '5',
						'order' => ['category.id' => 'asc']
					];

	public function initialize() {
		parent::initialize();
	}

	public function listCategory() 
	{
		$categorysTable = TableRegistry::get('categorys');
		$categorys_result = $categorysTable->find('all');

		if(!$categorys_result) {
			$this->Flash->error(__('Database category table empty !'));
		}

		$this->set('categorys', $this->paginate($categorys_result));
		$this->set('title', 'View list category ! ');
	}

	public function addCategory() 
	{
		$categorysTable = TableRegistry::get('Categorys');
		$category = $categorysTable->newEntity();

		if($this->request->is('POST')) {

			$data = $this->request->data;
			$category = $categorysTable->patchEntity($category, $data);
			$category->created = Time::now();

			if($categorysTable->save($category)) {
				$this->redirect(['controller' => 'categorys', 'action' => 'listCategory']);
				$this->Flash->success(__('Create new category !'));
			} else {
				$this->Flash->error(__('Error data !'));
			}

		}
		$this->set('title', 'Add a category new');
		$this->set('category', $category);
	}

	public function updateCategory()
	{	
		$id = $this->request->params['pass']['0'];
		if(!$id) {

			$this->redirect(['controller' => 'categorys', 'action' => 'listCategory']);
		} else {

			$categorysTable = TableRegistry::get('Categorys');
			$category = $categorysTable->newEntity();

			if($this->request->is('POST')) {
				$data = $this->request->data;
				$category = $categorysTable->patchEntity($category, $data);
				$category->category_id = $id;
				$category->updated = Time::now();

				if($categorysTable->save($category)) {
					$this->redirect(['controller' => 'categorys', 'action' => 'listCategory']);
					$this->Flash->success(__('Update recored ' . $id . ' category !'));
				} else {
					$this->Flash->error(__('Error data !'));
				}

			}

			$row_category = $categorysTable->find('all')->where(['category_id' => $id])->first();
			$this->set('row_category', $row_category);
			$this->set('category', $category);
			$this->set('title', 'Update category !');
		}

	}

	public function deleteCategory() 
	{	
		$id = $this->request->params['pass'][0];	
		if(!$id) {
			$this->redirect(['controller' => 'categorys', 'action' => 'listCategory']);
		} else {
			$categorysTable = TableRegistry::get('categorys');
			$category = $categorysTable->find('all')->where(['category_id' => $id])->first();
			
			if($categorysTable->delete($category)) {
				$this->redirect(['controller' => 'categorys', 'action' => 'deleteCategory']);
				$this->Flash->success(__('Delete category success !'));
			} else {
				$this->Flash->error(__('Error data !'));
			}

		}

	}

}
