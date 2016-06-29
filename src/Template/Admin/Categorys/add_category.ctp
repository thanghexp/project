
<fieldset>
	<?php echo $this->Form->create($category); ?>
	<legend><?php echo isset($title) ? $title : '';  ?></legend>
	<div class="row">
		<div class="form-group">
		  <!-- <label for="usr">Name Category:</label> -->
		  <div class="col-md-6">
		  	<?php echo $this->Form->input('name_category', ['class' => 'form-control', 'placeholder' => 'Name category']); ?>
		  </div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->button('Create', ['class' => 'btn btn-primary', 'style' => 'float:right; margin-top: 10px;']); ?>
		</div>
	</div>
	<?php echo $this->Form->end; ?>
</fieldset>
