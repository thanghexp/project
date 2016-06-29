<fieldset>
	<?php echo $this->Form->create($customer, ['validate' => true]); ?>
		<legend><?php echo (__('Register customer')); ?></legend>

	<div class="form-group">
		<?php echo $this->Form->input('username', ['class' => 'form-control', 'placeholder' => 'Username']); ?>
	</div>

	<div class="form-group">
		<?php echo $this->Form->input('password', ['class' => 'form-control', 'placeholder' => 'Password']); ?>
	</div>

	<div class="form-group">
		<?php echo $this->Form->input('confirm_password', ['class' => 'form-control', 'type' => 'password', 'placeholder' => 'Confirm Password']); ?>
	</div>

	<div class="form-group">
		<?php echo $this->Form->input('last_name', ['class' => 'form-control', 'placeholder' => 'Lass_name']); ?>
	</div>

	<div class="form-group">
		<?php echo $this->Form->input('first_name', ['class' => 'form-control', 'placeholder' => 'First_name']); ?>
	</div>

	<div class="form-group">
		<?php echo $this->Form->input('phone_number', ['class' => 'form-control', 'placeholder' => 'Phone_number']); ?>
	</div>

	<div class="form-group">
		<?php echo $this->Form->input('email', ['class' => 'form-control', 'placeholder' => 'Email']); ?>
	</div>

	<div class="form-group">
		<?php echo $this->Form->input('address', ['class' => 'form-control', 'placeholder' => 'Address']); ?>
	</div>

	<?php echo $this->Form->button('Register', ['class' => 'btn btn-primary', 'style' => 'float:right']); ?>
	<?php echo $this->Form->end; ?>
	
 </fieldset>
