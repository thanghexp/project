<?php echo $this->Form->create(); ?>
<div class="form-group">
	<?php echo $this->Form->input('new_password', ['placeholder' =>  'New Password', 'type' => 'password', 'class' => 'form-control']); ?>
</div>
<div class="form-group">
	<?php echo $this->Form->input('confirm_password', ['placeholder' => 'Confirm Password', 'type' => 'password', 'class' => 'form-control']); ?>
</div>
	<?php echo $this->Form->button('Changed', ['class' => 'btn-success']) ?>
<?php echo $this->Form->end(); ?>

