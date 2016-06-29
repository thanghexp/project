<fieldset>
	<legend><?php echo __(isset($title) ? $title : ''); ?></legend>
</fieldset>
<?php if(isset($info) > 0) { ?>
<div class="row"> 
    <div class="container" style="margin: 10px 0px; padding: 0px 0px 10px;">
    
      <h3 style="margin: 0px 20px; float:left;">
          Code ID : 
          <b style="border:2px solid red; margin-top: 20px">
              <?php echo isset($info->code_order) ? $info->code_order : ''; ?>
          </b>
      </h3>
      <h4 style="margin: 0px; margin-right: 70px; float:right;">
          <b>Updated Date : </b>
              <?php echo isset($info->updated) ? $info->updated->i18nFormat('yyyy-MM-dd hh:mm') : '-'; ?>
      </h4>
      <h4 style="margin: 0px 20px; float:right;">
	      <b>Created Date : </b>
	          <?php echo isset($info->created) ? $info->created->i18nFormat('yyyy-MM-dd hh:mm') : '-'; ?>
	  </h4>
      
   </div>
    
  <?php if(count($info['customer']) > 0) { ?>
      <ul style="font-size: 20px;list-style: none; margin-left: -160px">
        <li class="col-md-5 col-md-offset-2"><b>Full name: </b><?php echo isset($info['full_name']) ? $info['full_name'] : ''; ?> </li>
        <li class="col-md-5"><b>Address :</b><?php echo isset($info['customer']['address']) ? $info['customer']['address'] : ''; ?> </li>
        <li class="col-md-5 col-md-offset-2"><b>Phone number : </b> <?php echo isset($info['customer']['phone_number']) ? $info['customer']['phone_number'] : ''; ?> </li>
        <li class="col-md-5"><b>Email: </b><?php echo isset($info['customer']['email']) ? $info['customer']['email'] : ''; ?> </li>
      </ul>
  <?php } ?>
</div>
<?php } ?>

<?php echo $this->Form->create(); ?>
<table class = "table table-responsive table-stripped">
	<tr class = "bg-primary">
		<th class="text-center"><?php echo $this->Form->input('checkAll', ['type' => 'checkbox', 'label' => false, 'style' => 'margin: -8px 14px', 'id' => 'checkAll' ]); ?></th>
		<th class='text-center'>ID Order</th>
		<th class="text-center">ID Product</th>
		<th>Name Product</th>	
		<th>Qty</th>
		<th>Money</th>
		<th></th>
	</tr>
	<?php foreach($result_order_product as $row) { ?> 
	<tr>
		<td><?php echo $this->Form->input('check', ['type' => 'checkbox', 'label' => FALSE, 'name' => 'check['. $row->product_id .']', 'style' => 'margin-left: 20px;']) ?></td>
		<td class="text-center"><?php echo isset($row->order->order_id) ? '<b>' . $row->order->order_id . '</b>' : '-'; ?></td>
		<td class="text-center"><?php echo isset($row->product_id) ? '<b>' . $row->product_id . '</b>' : '-'; ?></td>
		<td><?php echo isset($row->product->name_product) ? $row->product->name_product : '-'; ?></td>
		<td><?php echo $this->Form->input('qty_order', ['default' => $row->qty, 'name' => 'qty_order['. $row->product_id .']', 'label' => false]) ?></td>
		<td><?php echo isset($row->qty) && isset($row->product->price) ? '<b>' . number_format($row->qty * $row->product->price, 3) . ' VND' . '</b>': '';  ?></td>
		<td>
			<!-- <a href="<?php echo $this->request->webroot . 'admin/rows/updaterow/'. $row->row_id; ?>"><img src="<?php echo $this->request->webroot . 'img/edit.png'; ?>" alt="..."></a> -->
			<a href="<?php echo $this->request->webroot . 'admin/OrderProducts/deleteOrderProduct/'. $row->order_id . '/' . $row->product_id;  ?>" onclick="checkDelete(event)" ><img src="<?php echo $this->request->webroot . 'img/erase.png'; ?>" alt="..."></a>
		</td>
	</tr>
	<?php } ?>
	<tr>
		<td></td>
	</tr>
</table>


	<div class="row" style="margin-left: 30px;">
		
		<div class="col-md-5">
			<?php if( $row_order->status != 3 || $row_order->status != 4 ) { ?>
				<?php echo $this->Form->input('status', ['options' => $dropdown_status, 'id' => 'status', 'default' => $row_order->status, 'label' => false, 'style' => 'float: left; margin: 0px 5px;']); ?>
				<?php echo $this->Form->button(__('Change Status'), ['class' => 'btn btn-primary' , 'style' => 'float: left; margin-left:10px;', 'onclick' => 'actions(event)', 'name' => 'change', 'value' => 'true']); ?>
			<?php } ?>
		</div>

		<div class="col-md-3 col-md-offset-4" style="float:right;">
			<?php if( $row_order->status != 3 || $row_order->status != 4 ) { ?>
				<?php echo $this->Form->button(__('Update'), ['class' => 'btn btn-danger', 'name' => 'update', 'value' => true, 'float: right']); ?>
			<?php } ?>
			<a href="<?php echo $this->request->webroot . '/admin/orders/listOrder'; ?>" class="btn btn-success">To list Order</a>
		</div>
	</div>	
	<?php echo $this->Form->end; ?>

	<?php if( $row_order->status != 3 || $row_order->status != 4 ) { ?>
		<fieldset style="margin-top: 50px;">
			<legend><?php echo __('Add new order product '); ?></legend>
		</fieldset>

		<?php echo $this->Form->create(); ?>

			<div class="row" style="margin-top: 10px; padding-bottom: 10px;">
				<div class="container" style="margin-left:25px;">
					<div class="col-md-5">
						<?php echo $this->Form->input('product_id', ['id' => 'product_id','class' => 'form-control', 'options' => $dropdown_product, 'placeholder' => 'First_name', 'onchange' => 'changeProduct()']); ?>
					</div>
					<div class="col-md-5">			
						<?php echo $this->Form->input('qty', ['id' => 'qty','class' => 'form-control', 'onblur' =>'checkLimit()', 'placeholder' => 'qty', 'default' => 0]); ?>
					</div>
					<div class="col-md-2">
						<?php echo $this->Form->button(__('Add more'), ['class' => 'btn btn-default', 'name' => 'add', 'value' => true, 'float: right', 'onclick' => 'checkQty(event)', 'style' => 'margin-top: 26px;']); ?>
					</div>
				</div>
			</div>

		<?php echo $this->Form->end(); ?>
	<?php } ?>



	<script>
		function checkQty(event) {
			if(parseInt($('#qty').val()) <= 0 || !$('#qty').val()) {
				parseInt($('#qty').val(0));
				alert('Qty must be value > 0');
				event.preventDefault();
			} 
		}

		function checkLimit() {
				$.ajax({
					'url' : "<?php echo $this->request->webroot . 'admin/products/dataQtyProduct';  ?>",
					'type' : 'POST',
					'dataType' : 'text',
					'data' : {
								'product_id' : $('#product_id').val()
							 },
					success : function(qty_product) {
						if(parseInt($('#qty').val()) >  parseInt(qty_product)) {
							$('#qty').val(qty_product);
							alert('This product only have qty is :' + qty_product);
						} 
						// return true;
					}
				});
			}
		
	</script>