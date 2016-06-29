<fieldset>
	<?php echo $this->Form->create($invoice); ?>
	<legend><?php echo (__('Create new a infomation invoice')); ?></legend>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('order_id', ['class' => 'form-control', 'default' => $row_invoice->customer_id, 'options' => $dropdown_customer]); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('product_id', ['class' => 'form-control', 'default' => $row_invoice->product_id, 'options' => $dropdown_product]); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('desk_id', ['class' => 'form-control', 'default' => $row_invoice->desk_id, 'options' => $dropdown_desk]); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<?php echo $this->Form->input('qty', ['class' => 'form-control', 'default' => $row_invoice->qty, 'placeholder' => 'Qty']); ?>	
		</div>
	</div>

	<div class="form-group">
		<?php echo $this->Form->button(__('Update Invoice'), ['class' => 'btn btn-primary', 'style' => 'float: right; margin-top: 15px;']); ?>
	</div>

	<?php echo $this->Form->end; ?>

</fieldset>