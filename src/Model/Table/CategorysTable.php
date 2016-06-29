<?php

namespace Cake\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategorysTable extends Table {

	public function initialize(array $config)
	{

	}

	public function validationDefault(validator $validator)
	{
		return $validator
						->requirePresence('name_category')
						->notEmpty('name_category', 'The field category name not empty');
	}

}