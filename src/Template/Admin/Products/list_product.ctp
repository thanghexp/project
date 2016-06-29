<fieldset>
	<legend><?php echo __(isset($title) ? $title : ''); ?></legend>
</fieldset>
<table class = "table table-responsive table-stripped">
	<tr class = "bg-primary">
		<th>ID</th>
		<th>Category</th>
		<th>Image</th>
		<th>Name Product</th>
		<th>Price</th>
		<th>Qty</th>
		<th>Create date</th>
		<th>Update date</th>
		<th></th>
	</tr>
	<?php foreach($products as $product) { ?> 
	<tr>
		<td><?php echo isset($product->product_id) ? $product->product_id : ''; ?></td>
		<td><?php echo isset($product->category->name_category) ? $product->category->name_category : ''; ?></td>
		<td><img src="<?php echo isset($product->image) ? $this->request->webroot . $product->image : ''; ?>" width="40" height="40" alt="Not found" /></td>
		<td><?php echo isset($product->name_product) ? $product->name_product : ''; ?></td>
		<td><?php echo isset($product->price) ? $product->price : ''; ?></td>
		<td><?php echo isset($product->qty) ? $product->qty : ''; ?></td>
		<td><?php echo (!$product->created) ?  '-' : $product->created->i18nFormat('yyyy-MM-dd'); ?></td>
		<td><?php echo (!$product->updated) ?  '-' : $product->updated->i18nFormat('yyyy-MM-dd'); ?></td>
		<td>
			<a href="<?php echo $this->request->webroot . 'admin/products/updateProduct/'. $product->product_id; ?>"><img src="<?php echo $this->request->webroot . 'img/edit.png'; ?>" alt="..."></a>
			<a href="<?php echo $this->request->webroot . 'admin/products/deleteProduct/'. $product->product_id;  ?>" onclick="checkDelete(event)"><img src="<?php echo $this->request->webroot . 'img/erase.png'; ?>" alt="..." ></a>
		</td>
	</tr>
	<?php } ?>
</table>

<ul class="pagination">
	<li><?php echo $this->Paginator->first(); ?></li>
	<li><?php echo $this->Paginator->prev(); ?></li>
	<li><?php echo $this->Paginator->numbers(); ?></li>
	<li><?php echo $this->Paginator->next(); ?></li>
	<li><?php echo $this->Paginator->last(); ?></li>

</ul>


<script>
	function checkDelete(event) {
        var message = confirm('Do you really delete this record !');
        if(message == false) {
            event.preventDefault();
        }
    }
</script>
