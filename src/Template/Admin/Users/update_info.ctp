
<fieldset>
	<?php echo $this->Form->create($user); ?>
		<legend><?php echo (__('Update infomation personal')); ?></legend>
	
	<div class=form-group>
		<div class="col-md-6">
			<?php echo $this->Form->input('username', ['class' => 'form-control', 'placeholder' => 'Username', 'disabled' => 'true']); ?>
		</div>
	</div>

	<div class=form-group>
		<div class="col-md-6">
			<?php echo $this->Form->input('last_name', ['class' => 'form-control', 'placeholder' => 'Lass_name']); ?>
		</div>
	</div>

	<div class=form-group>
		<div class="col-md-6">
			<?php echo $this->Form->input('first_name', ['class' => 'form-control', 'placeholder' => 'First_name']); ?>
		</div>
	</div>

	<div class=form-group>
		<div class="col-md-6">
			<?php echo $this->Form->input('phone_number', ['class' => 'form-control', 'placeholder' => 'Phone_number']); ?>
		</div>
	</div>
		
	<div class=form-group>
		<div class="col-md-6">
			<?php echo $this->Form->input('email', ['class' => 'form-control', 'placeholder' => 'Email']); ?>
		</div>
	</div>

	<div class=form-group>
		<div class="col-md-6">
			<?php echo $this->Form->input('address', ['class' => 'form-control', 'placeholder' => 'Address']); ?>
		</div>
	</div>

	<div class=form-group>
		<?php echo $this->Form->button('Update', ['class' => 'btn btn-primary', 'style' => 'margin: 25px 15px; float:right;']); ?>
	</div>

	<?php echo $this->Form->end; ?>
 </fieldset>
