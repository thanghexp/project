<?php
namespace App\Controller;

use  App\Controller\AppController;
use  Cake\ORM\TableRegistry;
use  Cake\Controller\Component\CookieComponent;
use  Cake\I18n\Time;

class ProductsController extends AppController {
	
	public $paginate = [
				'limit' => 6,
				'order' => ['products.id' => 'asc']
			];

	public function initialize() {
		parent::initialize();
		$this->loadComponent('Cookie');
	}

	public function viewProduct($category_id = null) {
		$productsTable = TableRegistry::get('products');
	
		if($category_id) {
			$products = $productsTable->find('all')->where(['category_id' => $category_id]);	
		} else {
			$products = $productsTable->find('all');	
		}

		$this->set('products', $this->paginate($products));
	}

	public function orderProduct() {
		/*SESSION*/
		$session = $this->request->session();

		$cart = $session->read('my_cart');

		if(isset($cart)) {	
			
			$data = $this->request->data();
			$productsTable =  TableRegistry::get('products');

			$data_product_first = $productsTable->find('all')->where(['product_id' => $data['product_id']])->first();

			if($data['qty'] > $data_product_first->qty) {
				echo $data_product_first->qty; die;
			} else {
				foreach($cart as $key => $value) {
					if($value['product_id'] == $data['product_id']) {
						$cart[$key] = $data;
						
						$session->write('my_cart', $cart);
						$cart = $session->read('my_cart');
						$this->listOrder($cart); die;	
						// $product = $productsTable->find('all')->where(['product_id' => $value['product_id']])->first();		
					}
				}
			}

			
			# 10/06/2016 9:22
			$cart[] = $data;
			$session->write('my_cart', $cart);
			$cart = $session->read('my_cart');
			$this->listOrder($cart); die;
		} 
		// else {
			
		// }	

		$data[] = $this->request->data();
		// debug($data); die;
		$session->write('my_cart', $data);
		$cart = $session->read('my_cart');
		$this->listOrder($cart); die;

		/* COOKIE*/
		/*$this->loadComponent('Cookie');
		// $this->Cookie->write('my_cart',12345);
		$data = $this->request->data();
		
		$cart = $this->Cookie->read('User.name');
		debug($cart); die;
		if(isset($cart)) {
			$cart = array_merge($cart, $data);
			debug($cart); die;	
			$this->Cookie->write('cart', $cart);
		} else {
			//debug($data); die;
			//$this->Cookie->write('cart', [1=>[123, 345]]);
		}	*/
	}

	public function checkQtyOrder() {
		$productsTable = TableRegistry::get('products');
		$data = $this->request->data();
		
		if(isset($data)) {
			$products = $productsTable->find('all')->where(['product_id' => $data['product_id']])->first();

			if($data['qty'] > $products->qty) {
				echo '<script>alert("You have ordered pass limit qty accept !");</script>';
			}
			die;
		}

	}

	public function listOrder($cart) {
		$productsTable = TableRegistry::get('products');
		echo '<table class="table table-responsive"><tr class="bg-primary">';
        echo '<th>Id product</th>';
        echo '<th>Name product</th>';
		echo '<th>Qty</th>';                
		echo '<th>Price</th>';                
        echo '</tr>';  

		foreach($cart as $key => $value) {
			$row_product = $productsTable->find('all')->where(['product_id' => $value['product_id']])->first();
			
			echo "<tr>";
			echo "<td>". $row_product->product_id  ."</td>";
			echo "<td>". $row_product->name_product  ."</td>";
			echo "<td>". $value['qty']  ."</td>";
			echo "<td>". number_format($value['qty'] * $row_product->price, 3)."</td>";
			echo "</tr>";
		}
		echo '</table>';
		die;
	}

	public function detailProduct($product_id = null) {
		$productsTable = TableRegistry::get('products');
		$row_product = $productsTable->find('all');
		
		$this->set('row_product', $row_product);
	}

}
