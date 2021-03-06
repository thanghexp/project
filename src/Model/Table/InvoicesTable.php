<?php 

namespace Cake\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\validator;

class InvoicesTable extends Table {
	
	public function initialize(array $config) 
	{		
		$this->belongsTo('orders', [
				'className' => 'orders',
				'dependent' => true,
				'foreignKey' => 'order_id'
			]);


	}

	public function validationDefault(validator $validator) {
		return $validator
						 ->requirePresence('qty')
			   			 ->notEmpty('qty', 'The field qty not empty !')
			   			 ->add('qty', [
			   			 	'numeric' => [
								'rule' => 'numeric',
								'message' => 'Please enter only numbers',
								'allowEmpty' => true,
								'required' => false,
							]
			   			 ]);
	}

}