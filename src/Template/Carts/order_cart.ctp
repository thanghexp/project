<?php echo $this->Form->create('form', ['url' => '/carts/updateCart']); ?>
<table class="table table-responsive" id="result">
  <tr class="bg-primary">
    <th>Id Product</th>
    <th>Name Product</th>
    <th>Qty</th>
    <th>Money</th>
    <th></th>
  </tr>
  <?php if(isset($products_cart)) { foreach($products_cart as $product) { ?> 
    <tr>
      <td><?php echo isset($product->product_id) ? $product->product_id : ''; ?></td>
      <td><?php echo isset($product->name_product) ? $product->name_product : ''; ?></td>
      <td><?php echo $this->Form->input('qty', ['name' => 'qty[' . $product->product_id . ']','id' => 'qty_product' . $product->product_id, 'default' => isset($cart[$product->product_id]) ? $cart[$product->product_id] : '', 'label' => FALSE]); ?></td>
      <td><?php echo number_format($product->price * $cart[$product->product_id], 3) . ' VND'; ?></td>
      <td>
          <a href="<?php echo $this->request->webroot .'carts/removeCart/' . $product->product_id; ?>"><img src="<?php echo $this->request->webroot . 'webroot/img/erase.png'; ?>" onclick="message(event)"></a>
         <!--  <a href="#" id="updateCart($product->qty)"><img src="<?php echo $this->request->webroot . 'webroot/img/edit.png'; ?>"></a> -->
      </td>
    </tr>
  <?php } } ?>
</table>
<?php echo $this->Form->end; ?>


<a href="<?php echo $this->request->webroot . 'products/view-product';  ?>" class="btn btn-default"><span aria-hidden="true">&larr;</span>Back to shopping</a>
<a href="<?php echo $this->request->webroot . 'carts/saveCart';  ?>" class="btn btn-success" style="float: right;">Send</a>
<?php echo $this->Form->button(__('Change'), ['class' => 'btn btn-primary', 'style' => 'float: right; margin-right: 5px;']); ?>


<script type="text/javascript">
    function message(event) {
        var message = confirm("Do you have really this product get out my cart ?");
        if(message == false) {
          event.preventDefault();
        }
    }
</script>