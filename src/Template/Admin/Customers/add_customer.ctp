<fieldset>
	<?php echo $this->Form->create($customer); ?>
	<legend><?php echo (__('Create new a customer')); ?></legend>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('last_name', ['class' => 'form-control', 'placeholder' => 'Lass_name']); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('first_name', ['class' => 'form-control', 'placeholder' => 'First_name']); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('phone_number', ['class' => 'form-control', 'placeholder' => 'Phone_number']); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('email', ['class' => 'form-control', 'placeholder' => 'Email']); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('address', ['class' => 'form-control', 'placeholder' => 'Address']); ?>
		</div>
	</div>

	<?php echo $this->Form->end; ?>

	<div class="form-group">
		<div class="col-md-6">
	  		<?php echo $this->Form->button('Create new', ['class' => 'btn btn-primary', 'style' => 'float:right; margin-top: 25px;']); ?>
	  	</div>
	</div>
	<?php echo $this->Form->end; ?>
</fieldset>