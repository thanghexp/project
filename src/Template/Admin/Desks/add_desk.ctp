<fieldset>
	<?php echo $this->Form->create($desk); ?>
	<legend><?php echo isset($title) ? $title : ''; ?></legend>

	<div class="form-group">
	 	<div class="col-md-6">
	 		<label for="usr">Name Desk:</label>
	  		<?php echo $this->Form->input('name_desk', ['label' => FALSE, 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Name Desk']); ?>
	 	</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
	  		<label for="usr">Number Chair:</label>
	  		<?php echo $this->Form->input('number_chair', ['label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Number chair']); ?>
	  	</div>
	</div>

	<div class="form-group">
		<?php echo $this->Form->button('Create', ['class' => 'btn btn-primary', 'style' => 'float:right; margin-top: 15px;']); ?>
	</div>
	
	<?php echo $this->Form->end; ?>
</fieldset>