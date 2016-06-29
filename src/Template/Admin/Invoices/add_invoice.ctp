<fieldset>
	<?php echo $this->Form->create($invoices); ?>
	<legend><?php echo (__('Create new a infomation invoice')); ?></legend>

	<div class="row">
		<div class="form-group">
			<div class="col-md-6">
				<?php echo $this->Form->input('order_id', ['class' => 'form-control', 'options' => $dropdown_orderid]); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
				<?php echo $this->Form->input('product_id', ['class' => 'form-control', 'options' => $dropdown_product]); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
				<?php echo $this->Form->input('desk_id', ['class' => 'form-control', 'options' => $dropdown_desk]); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
				<?php echo $this->Form->input('qty', ['class' => 'form-control', 'placeholder' => 'Qty']); ?>
			</div>
		</div>
	</div>

			<?php echo $this->Form->button(__('Create Invoices'), ['class' => 'btn btn-primary', 'style' => 'float: right; margin-top: 10px;']); ?>

	<?php echo $this->Form->end; ?>

</fieldset>