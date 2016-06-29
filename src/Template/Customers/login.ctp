<?php echo $this->Form->create(); ?>
	<div class="form-group" role="form">
		<label>Username :</label>
		<div>
			<?php echo $this->Form->input('username', ['class="form-control"', 'placeholder' => 'Username', 'label' => false]); ?>		
		</div>
	</div>
	<div class="form-group" role="form">
		<label>Password</label>
		<div>
			<?php echo $this->Form->input('password', ['class="form-control"', 'placeholder' => 'Password', 'label' => false]); ?>
		</div>
	</div>
	<div>
		<?php echo $this->Form->input('remember_password', ['type' => 'checkbox']); ?>
	</div>
	<div>
		<?php echo $this->Form->button('Login', ['class' => 'btn btn-success', 'style' => 'float:right']); ?>
	</div>
<?php echo $this->Form->end; ?>