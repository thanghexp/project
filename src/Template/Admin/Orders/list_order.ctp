<fieldset>
	<legend><?php echo __('View list customer order !'); ?></legend>
	<?php echo $this->Form->create(); ?>
	<div class="form-search">
		<div class="form-group">
			<div class="col-md-3">
				<?php echo $this->Form->input('search_status', ['options' => $dropdown_status, 'name' => 'search_status', 'class' => 'form-control', 'label' => false]); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-3">
				<?php echo $this->Form->input('search_code_order', ['class' => 'form-control', 'placeholder' => 'Code order', 'label' => false, 'id' => 'search_code_order']); ?>	
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-3">
				<?php echo $this->Form->input('search_updated', ['class' => 'form-control', 'placeholder' => 'Updated', 'label' => false]); ?>	
			</div>
		</div>

		
		<div class="form-group">
			<?php echo $this->Form->button('Search', ['class' => 'btn btn-default', 'value' => 'search', 'id' => 'search', 'name' => 'search']); ?>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</fieldset>

<?php echo $this->Form->create(); ?>
<table class="table table-responsive ">
	<tr class="bg-primary">
		<th class="text-center" style="padding: 0px 15px;"><?php echo $this->Form->input('checkall', ['id' => 'checkAll', 'type' => 'checkbox', 'label' => FALSE]); ?></th>
		<th class="text-center">ID</th>
		<th>Code ID</th>
		<th>Name Customer</th>
		<th>Status</th>
		<th>Update Date</th>
		<th></th>
	</tr>
	<tbody id="result">
	<?php foreach($orders as $order) { ?> 
		<tr>
			<td class="text-center"><?php echo $this->Form->input('ids['. $order->order_id.']', ['type' => 'checkbox', 'label' => false, 'class' => 'checked']); ?></td>
			<td class="bg-success text-center"><?php echo isset($order->order_id) ? '<b>' . $order->order_id. '</b>' : ''; ?></td>
			<td>
				<a href="<?php echo $this->request->webroot . 'admin/orderProducts/listOrderProduct/' . (isset($order->code_order) ? $order->code_order : ''); ?>">
					<?php echo isset($order->code_order) ? $order->code_order : ''; ?>
				</a>
			</td>
			<td>
				<?php echo isset($order->customer->last_name) && isset($order->customer->first_name) ? ( $order->customer->last_name . ' ' . $order->customer->first_name ) : ''; ?>
			</td>
			<td>
				<?php if(isset($order->status)) {if($order->status == 0) {echo 'Order';} else if($order->status == 1) {echo 'Approve';} else {if($order->status == 2) {echo 'Transfer';} else {echo 'Paid';}}} ?>
			</td>
			<td><?php echo (!$order->updated) ?  '-' : $order->updated->i18nFormat('yyyy-MM-dd hh:mm'); ?></td>
			<td>
				<?php if($order->status != 3) { ?>
					<a href="<?php echo $this->request->webroot . 'admin/orders/updateOrder/'. $order->order_id; ?>" >
						<img src="<?php echo $this->request->webroot . 'img/edit.png'; ?>" alt="...">
					</a>
				
					<a href="<?php echo $this->request->webroot . 'admin/orders/deleteOrder/'. $order->order_id;  ?>" onclick="checkDelete(event)">
						<img src="<?php echo $this->request->webroot . 'img/erase.png'; ?>" alt="...">
					</a>
				<?php } ?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>



<div class="row">
	<?php echo $this->Form->input('action', ['options' => $dropdown_action, 'id' => 'action', 'onchange' => 'updateStatus()', 'label' => false, 'style' => 'float: left; margin-left:25px;']); ?>
	<?php echo $this->Form->input('status', ['options' => $dropdown_status, 'id' => 'status', 'disabled' => true, 'label' => false, 'style' => 'float: left; margin: 0px 5px;']); ?>
	<?php echo $this->Form->button(__('Action'), ['class' => 'btn btn-primary' , 'style' => 'float: left; margin-left:10px;', 'onclick' => 'actions(event)', 'value' => 'action']); ?>


	<ul class="pagination">
		<li><?php echo $this->Paginator->first(); ?></li>
		<li><?php echo $this->Paginator->prev(); ?></li>
		<li><?php echo $this->Paginator->numbers(); ?></li>
		<li><?php echo $this->Paginator->next(); ?></li>
		<li><?php echo $this->Paginator->last(); ?></li>
	</ul>
</div>
<?php echo $this->Form->end; ?>
