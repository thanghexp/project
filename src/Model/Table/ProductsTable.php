<?php 

namespace Cake\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\validator;

class ProductsTable extends Table {
	
	public function initialize(array $config) 
	{
		$this->belongsTo('categorys', [
				'className' => 'categorys',
				'dependent' => true,
				'foreignKey' => 'category_id'
			]);	
	}

	public function validationDefault(validator $validator) {
		return $validator
						 ->requirePresence('name_product')
			   			 ->notEmpty('name_product', 'The field name product not empty !')
			   			 ->requirePresence('price')
			   			 ->notEmpty('price', 'The field price not empty');
	}

}