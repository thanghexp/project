<?php 
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class ProductsController extends AppController {

	public $paginate = [
				'limit' => 5,
				'order' => ['products.id' => 'asc']
			];


	public function listProduct() 
	{
		$productsTable = TableRegistry::get('products');
		$result_product = $productsTable->find('all')
										->select([
												'product_id', 'name_product', 'qty',
												'categorys.name_category' , 'products.created',
												'price', 'products.updated', 'image'
										])
										->contain('categorys');

		if(!$result_product) {
			$this->Flash->error(__('Database products table empty'));
		}

		$this->set('products', $this->paginate($result_product));
		$this->set('title', 'List view a product !');
	}

	public function addProduct() 
	{
		$this->loadComponent('Upload');
		$productsTable     = TableRegistry::get('Products');
		$product           = $productsTable->newEntity();
		
		$category_dropdown = TableRegistry::get('categorys')->find('list', ['keyField' => 'category_id', 'valueField' => 'name_category']);

		if($this->request->is("POST")) {
				
			$data             = $this->request->data;
			$product          = $productsTable->patchEntity($product, $data);
			$product->created = Time::now(); 

			$file_upload = $data['image'];
			if($file_upload) {
				
				$this->Upload->upload($file_upload, ROOT . DS . 'webroot' . DS . 'upload/product/');
				if($this->Upload->result) {
					if(isset($product)) {
						$product->image = 'upload/product/' . $this->Upload->result;
						if($productsTable->save($product)) {
							$this->Flash->success(__('Create new Product success'));
							return $this->redirect(['controller' => 'products', 'action' => 'listProduct']);
						} else {
							$this->Flash->error(__(" Errors "));
						}
					}

				}
				
			}

		}

		$this->set(compact('category_dropdown', $category_dropdown));
		$this->set(compact('product', $product));
		$this->set('title', 'Add new a product');
	}

	public function updateProduct()
	{

		$id = $this->request->params['pass']['0'];
		if(!isset($id)) {
			$this->redirect(['controller' => 'products', 'action' => 'listProduct']);
			$this->Flash->error(__('Not Found Product !'));
		} else {

			$productsTable = TableRegistry::get('Products');
			$product       = $productsTable->newEntity();

			if($this->request->is("POST")) {
				
				$data                = $this->request->data;
				$product             = $productsTable->patchEntity($product, $data);
				$product->product_id = $id;
				$product->updated    = Time::now();

				$this->loadComponent('Upload');	
				$image_upload = $data['image'];
				if($image_upload) {
					$this->Upload->upload($image_upload, ROOT . DS . 'webroot'. DS . 'upload/product/');

					if($this->Upload->result) {
						$product->image = 'upload/product/' . $this->Upload->result;
					}
				}

				if(isset($product)) {
					if($productsTable->save($product)) {
						$this->redirect(['controller' => 'products', 'action' => 'listProduct']);
						$this->Flash->success(__('Update this Product success'));
					} else {
						$this->Flash->error(__(" Errors "));
					}
				}

			}
		}
		$category_dropdown = TableRegistry::get('categorys')->find('list', ['fieldList' => 'category_id', 'valueField' => 'name_category']);
		$row_product = $productsTable->find('all')->where(array('product_id' => $id))->first();
		$this->set('row_product', $row_product );
		$this->set('category_dropdown', $category_dropdown);
		$this->set('product', $product);
		$this->set('title', 'Update info a product');
	}

	public function deleteProduct()
	{
		$id = $this->request->params['pass']['0'];

		if(!$id) {
			$this->redirect(['controller' => 'product', 'action' => 'listProduct']);
			$this->Flash->error(__('Not Found Product !'));
		} else {
			$productsTable = TableRegistry::get('products');
			$row_product = $productsTable->find('all')->where(array('product_id' => $id))->first();

			if($productsTable->delete($row_product)) {				
				$this->Flash->success("Delete product" . $id . " success !");
			} else {
				$this->Flash->error("Errors");
			}

			$this->redirect(['controller' => 'products', 'action' => 'listProduct']);
		}

	}

	public function dataQtyProduct() {
		$productsTable = TableRegistry::get('products');
		$data = $this->request->data();

		$product = $productsTable->find('all')->where(['product_id' => $data['product_id']])->first();
		echo $product->qty;
		die;
	}

	public function dataPriceProduct() {
		$productsTable = TableRegistry::get('products');
		$data = $this->request->data();

		$product = $productsTable->find('all')->where(['product_id' => $data['product_id']])->first();
		echo '<b style="font-size: 25px;"> Total money:' . number_format($data['qty'] * $product->price, 3) . ' VND</b>';
		die;
	}

}