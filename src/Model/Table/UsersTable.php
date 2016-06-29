<?php

namespace App\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table {	

	public function initialize(array $config) {


	}


	public function validationDefault(Validator $validator) {
		return $validator->notEmpty('username', 'username not can empty !')
						 ->add('username', [
							 	'minlength' => [
							 		'rule' => ['maxlength', 10],
							 		'message' =>  'Username must smaller 10 characters' 
							 	], 
							 	'maxlength' => [
							 		'rule' => ['minlength', 6],
							 		'message' => 'Username must have least 6 characters '
							 	]
						 	])
						  //  ->add('username', 'unique',[
						 	// 	'rule' => 'validateUnique',
						 	// 	'message' => 'Username must unique'

						 	// ])  
						 	#CHECK UNIQUE
						   ->requirePresence('password')->notEmpty('password', 'password not can empty !')
						   ->add('password', [
						   		'maxlength' => [
						   				'rule' => ['minlength', 6],
						   				'message' => 'Password must have least 6 characters'
						   			],
						   	])
						   ->requirePresence('last_name')->notEmpty('last_name', 'last_name not can empty !' )
						   ->add('last_name', [
						   		'minlength' => [
						   			'rule' => ['minlength', 3],
						   			'message' => 'Last name must have least 3 characters ',
						   		],
						   	])
						   ->requirePresence('first_name')->notEmpty('first_name', 'first_name not can empty !' )
						   ->requirePresence('phone_number')->notEmpty('phone_number', 'phone_number not can empty !' )
						   ->add('phone_number', [
						   		'minlength' => [
						   			'rule' => ['minlength', 9],
						   			'message' => 'Phone number must have least 9 numbers'
						   		],
						   		'maxlength' => [
						   			'rule' => ['maxlength', 12],
						   			'message' => 'Phone number must smaller 12 numbers'
						   		]
						   	])
						   ->requirePresence('email')->notEmpty('email', 'email not can empty !' )
						   ->requirePresence('address')->notEmpty('address', 'address not can empty !');
	}

	public function validationUpdateInfo(Validator $validator) {
		return $validator ->requirePresence('last_name')->notEmpty('last_name', 'last_name not can empty !' )
						   ->add('last_name', [
						   		'minlength' => [
						   			'rule' => ['minlength', 3],
						   			'message' => 'Last name must have least 3 characters ',
						   		],
						   	])
						   ->requirePresence('first_name')->notEmpty('first_name', 'first_name not can empty !' )
						   ->requirePresence('phone_number')->notEmpty('phone_number', 'phone_number not can empty !' )
						   ->add('phone_number', [
						   		'minlength' => [
						   			'rule' => ['minlength', 9],
						   			'message' => 'Phone number must have least 9 numbers'
						   		],
						   		'maxlength' => [
						   			'rule' => ['maxlength', 12],
						   			'message' => 'Phone number must smaller 12 numbers'
						   		]
						   	])
						   ->requirePresence('email')->notEmpty('email', 'email not can empty !' )
						   ->requirePresence('address')->notEmpty('address', 'address not can empty !');
	}

	

	public function checkUsername() {
		$user = $this->find('all', ['conditions' => ['username' => $this->data['Valid']['username']]])->first();

		if($user) {
			return  TRUE;
		} 
		return FALSE;
	}

}