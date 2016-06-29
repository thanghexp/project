<fieldset>
	<legend><?php echo 'Login Page'; ?></legend>
</fieldset>

<?php echo $this->Facebook->initJsSDK(); ?>
<div class="container">
<?php echo $this->Form->create(); ?>
	<div class="row">
		<div class="form-group" role="form">
			<!-- <label>Username :</label> -->
			<div class="col-md-6">
				<?php echo $this->Form->input('username', ['class="form-control"', 'placeholder' => 'Username']); ?>	
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" role="form">
			<!-- <label>Password</label> -->
			<div class="col-md-6">
				<?php echo $this->Form->input('password', ['class="form-control"', 'placeholder' => 'Password']); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?php echo $this->Form->input('remember_password', ['type' => 'checkbox']); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?php echo $this->Facebook->loginLink($options = ['class' => 'fb-login-button', 'data-size' => 'xlarge']); ?>
			<?php echo $this->Form->button('Login', ['class' => 'btn btn-success', 'style' => 'float:right;']); ?>
		</div>
	</div>
<?php echo $this->Form->end; ?>

</div>