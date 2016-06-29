<fieldset>
	<?php echo $this->Form->create(); ?>
	<legend><?php echo (__('Order new at shop')); ?></legend>
	
	<div class="row" style="width:600px; float: left; margin-left: 50px; border-right: 1px solid #dfdfdf;">
		<div class="form-group">
			<div class="col-md-12">
				<?php echo $this->Form->input('product_id', ['class' => 'form-control', 'options' => $dropdown_product, 'placeholder' => 'First_name', 'id' => 'product_id', 'onchange' => 'changeProduct()']); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-12">
				<?php echo $this->Form->input('qty', ['class' => 'form-control', 'placeholder' => 'Qty', 'default' => 0, 'id' => 'qty', 'onkeyup' => 'general()']); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-12">
				<?php echo $this->Form->input('name_desk', ['class' => 'form-control', 'id' => 'name_desk', 'placeholder' => 'Name desk', 'required']); ?>
			</div>
		</div>

		<div id="result" style="float:left; margin: 20px 20px;font-size: 25px;" ><b>Total money: 0.000 VND</b></div>

		<div class="form-group">
			<a href="#" onclick="addMore()" style="float: right;margin: 25px 15px;" class="btn btn-primary">Add more</a>
		</div>
	</div>

	<div class="box2" style="float:left; margin-left:50px;">
		<div>
			<h4 style="border: 2px solid #e3e3e3; background: #dfdfdf;">View list product ordered</h4>
			<table class="table table-responsive ">
				<tr class="bg-primary">
					<th>ID</th>
			        <th>Name Product</th>
					<th>Qty</th>              
					<th>Total Money</th>             
			        <th class="text-center"></th>
				</tr>
				<tbody id="cart">
					<?php
						if(isset($list_product_order)) {
							foreach($list_product_order as $key => $value) { ?>
						<tr>
							<td class="text-center"><?php echo isset($value['product_id']) ? '<b>' . $value['product_id'] ."</b>" : ''; ?></td>
							<td><?php echo isset($value['name_product']) ? $value['name_product'] : ''; ?></td>
							<td><?php echo isset($value['qty']) ? $value['qty'] : ''; ?></td>
							<td class='text-center'><?php echo isset($value['price']) && isset($value['qty']) ? '<b>' . number_format($value['qty'] * $value['price'], 3) . '</b>' : ''; ?></td>
							<td>
								<a href="<?php echo $this->request->webroot . 'admin/orders/removeCartContact/'. $value['product_id'];  ?>" onclick="checkDelete(event)">
									<img src="<?php echo $this->request->webroot . 'img/erase.png'; ?>" alt="...">
								</a>
							</td>
						</tr>
					<?php }} ?>
				</tbody>
			</table>
		</div><!-- End#cart -->
		<div class="form-group">
			<?php echo $this->Form->button('Send', ['class' => 'btn btn-success', 'style' => 'float: right']); ?>
		</div>
	</div>	

	<?php echo $this->Form->end; ?>

</fieldset>

<script>

	function changeProduct() {
		$('#qty').val(0);
		$('#result').html('<b style="font-size: 25px;"> Total money:0.000 VND </b>');
	}

	function general() {
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

		$.ajax({
			'url' : "<?php echo $this->request->webroot . 'admin/products/dataPriceProduct';  ?>",
			'type' : 'POST',
			'dataType' : 'text',
			'data' : {
						'product_id' : $('#product_id').val(),
						'qty' : $('#qty').val()
					 },
			success : function(result) {
				return $('#result').html(result);
			}
		});
	}

	function addMore() {

		if(parseInt($('#qty').val()) <= 0 || !$('#qty').val()) {
			parseInt($('#qty').val(0));
			alert('Qty must be value > 0');
		} else {
			$.ajax({
				'url' : "<?php echo $this->request->webroot . 'admin/orders/addMore';  ?>",
				'type' : 'POST',
				'dataType' : 'text',
				'data' : {
							'product_id' : $('#product_id').val(),
							'qty' : $('#qty').val()
						 },
				success : function(result) {
					return $('#cart').html(result);
				}
			});
		}
		
	}
	
</script>