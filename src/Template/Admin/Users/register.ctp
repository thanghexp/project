
<fieldset>
	<?php echo $this->Form->create($user, ['validate' => true]); ?>
		<legend><?php echo (__('Register members')); ?></legend>
	<?php
		echo $this->Form->input('username', ['class' => 'form-control', 'placeholder' => 'Username']);
		echo $this->Form->input('password', ['class' => 'form-control', 'placeholder' => 'Password']);
		echo $this->Form->input('last_name', ['class' => 'form-control', 'placeholder' => 'Lass_name']);
		echo $this->Form->input('first_name', ['class' => 'form-control', 'placeholder' => 'First_name']);
		echo $this->Form->input('phone_number', ['class' => 'form-control', 'placeholder' => 'Phone_number']);
		echo $this->Form->input('email', ['class' => 'form-control', 'placeholder' => 'Email']);
		echo $this->Form->input('address', ['class' => 'form-control', 'placeholder' => 'Address']);
		echo $this->Form->button('Register');
		echo $this->Form->end; 
	 ?>
 </fieldset>
