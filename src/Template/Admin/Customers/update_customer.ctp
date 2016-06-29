<fieldset>
	<?php echo $this->Form->create($customer); ?>
	<legend><?php echo isset($title) ? $title : ''; ?></legend>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('last_name', ['class' => 'form-control', 'default' => $row_customer->last_name, 'placeholder' => 'Lass_name']); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
		<?php echo $this->Form->input('first_name', ['class' => 'form-control', 'default' => $row_customer->first_name, 'placeholder' => 'First_name']); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('phone_number', ['class' => 'form-control', 'default' => $row_customer->phone_number, 'placeholder' => 'Phone_number']); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('email', ['class' => 'form-control', 'default' => $row_customer->email, 'placeholder' => 'Email']); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('address', ['class' => 'form-control', 'default' => $row_customer->address, 'placeholder' => 'Address']); ?>
		</div>
	</div>

	<div class="form-group">
	  <?php echo $this->Form->button('Create new', ['class' => 'btn btn-primary', 'style' => 'float:right; margin: 15px 15px;']); ?>
	</div>
	<?php echo $this->Form->end; ?>
</fieldset>