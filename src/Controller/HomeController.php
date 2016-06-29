<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class HomeController extends AppController{

	public function initialize() {
		parent::initialize();
	}

	public function index() {
		$this->viewBuilder()->layout('home');

		$productsTable = TableRegistry::get('products');
		$products = $productsTable->find('all')->limit(7);

		$this->set('products', $products);
	}

}