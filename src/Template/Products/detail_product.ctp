<div class="row">
	<div class="col-md-3">
		<img src="<?php echo $this->request->webroot . isset($row_product->image) ? $row_product->image : ''; ?>"/>
	</div>
	<div class="col-md-6">
		<h3><?php isset($row_product->name_product) ? $row_product->name_product : ''; ?></h3>
		<p>Qty: <?php echo isset($row_product->qty) ? $row_product->qty : ''; ?></p>
		<p>Price: <?php echo isset($row_product->qty) ? $row_product->qty : ''; ?></p>
	</div>
</div>