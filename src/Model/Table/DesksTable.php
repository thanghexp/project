<?php

namespace Cake\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DesksTable extends Table {

	public function initialize(array $config) {
		// $this->hasMany();
	}

	public function validationDefault(validator $validator) 
	{
		return $validator
						->requirePresence('number_chair')
						->notEmpty('number_chair', 'The field number chair name not empty');
	}
}