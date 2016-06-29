<?php
namespace Cake\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrdersTable extends Table {

	public function initialize(array $config) {

		$this->belongsTo('customers', [
				'className' => 'customers',
				'dependent' => true,
				'foreignKey' => 'customer_id'
			]);	

		$this->hasMany('invoices', [
				'className' => 'invoices',
				'dependent' => true,
				'foriegnKey' => 'order_id'
			]);

		$this->hasMany('order_products', [
				'className' => 'orderProducts',
				'dependent' => true,
				'foriegnKey' => 'order_id'
			]);
	}


	 // public function validationDefault(validator $validator)
	 // {
	 // 	return $validator
	 // 					->requirePresence('name_category')
	 // 					->notEmpty('name_category', 'The field category name not empty');
	 // }
}