<fieldset>
	<?php echo $this->Form->create($product, ['type' => 'file']); ?>
	<legend><?php echo (__( isset($title) ? $title : '')); ?></legend>
	<div class="row">
		
		<div class="form-group">
			<div class="col-md-6">
			  <label for="usr">Choose Category:</label>
			  <?php echo $this->Form->input('category_id', ['options' => $category_dropdown ,'class' => 'form-control', 'label' => false, 'default' => $row_product->category_id]); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
			  <label for="usr">Price:</label>
			  <?php echo $this->Form->input('price', ['type' => 'number', 'label' => FALSE, 'class' => 'form-control', 'default' => $row_product->price]); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
			  <label for="usr">Name Product:</label>
			  <?php echo $this->Form->input('name_product', ['label' => FALSE, 'class' => 'form-control', 'default' => $row_product->name_product]); ?>
			</div>	
		</div>
		
		

		<div class="form-group">
			<div class="col-md-6">
			  <label for="usr">Qty:</label>
			  <?php echo $this->Form->input('qty', ['type' => 'number', 'label' => FALSE, 'class' => 'form-control', 'default' => $row_product->qty, 'Placeholder' => 'Qty']); ?>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-md-6">
				<label for="file"> File Image : </label>
				<?php echo $this->Form->input('image', ['type' => 'file', 'label' => FALSE]); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
		  		<?php echo $this->Form->button(__('Update'), ['class' => 'btn btn-primary', 'style' => 'float:right; margin-top: 15px;']); ?>
		  	</div>
		</div>

	</div>
	
	<?php echo $this->Form->end; ?>
</fieldset>