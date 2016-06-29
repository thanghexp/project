<h3 class="bg-primary" style="padding: 10px 10px; margin-top: -3px;">List products</h3>
<div class="row">
  <?php foreach($products as $product) { ?>
    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">
        <div style="height: 100px; text-align: center; margin-top: 10px;"><img src="<?php echo $this->request->webroot . $product->image ?>" alt="..." width="150" height="100"/></div>
        <div class="caption" id="<?php echo 'product_id' . $product->product_id; ?>">
          <h3><?php echo isset($product->name_product) ? $product->name_product : ''; ?></h3>
          <p><?php echo '<b>Qty : </b>'  . (isset($product->qty) ? $product->qty  : ''); ?></p>
          <p><?php echo '<b>Price :</b>' . (isset($product->price) ? number_format($product->price, 3) . '  VND' : ''); ?></p>
            <?php 
                if($product->qty > 0) {
                    echo $this->Form->input('order[' . $product->product_id . ']', ['class' => 'form-control', 'label' => false, 'style' => 'width: 70px; float: left;', 'type' => 'number', 'default' => 0, 'id' => 'product' . $product->product_id ]); 
                    echo $this->Form->button(__('Add to cart'), ['class' => 'btn btn-primary', 'id' => 'cart' . $product->id, 'onclick' => 'cart(' . $product->product_id . ')']);
                } else {
                    echo $this->Form->input('order[' . $product->product_id . ']', ['class' => 'form-control', 'label' => false, 'style' => 'width: 70px; float: left;', 'type' => 'number', 'default' => 0, 'id' => 'product' . $product->product_id, 'disabled' => 'true' ]); 
                    echo $this->Form->button(__('Out of stock'), ['class' => 'btn btn-danger', 'disabled' => 'true', 'id' => 'cart' . $product->id, 'onclick' => 'cart(' . $product->product_id . ')']);
                }
             ?>
        </div>
      </div>
    </div>
  <?php } ?>
</div>

<ul class="pagination">
  <li><?php echo $this->Paginator->first();  ?></li>
  <li><?php echo $this->Paginator->prev(); ?></li>
  <li><?php echo $this->Paginator->numbers(); ?></li>
  <li><?php echo $this->Paginator->next(); ?></li>
  <li><?php echo $this->Paginator->last(); ?></li>
</ul>


<script type="text/javascript">
  function cart(product_Id) {
    
    $.ajax({
        url : "<?php echo $this->request->webroot . 'products/orderProduct'; ?>",
        type : "post",
        dateType:"text",
        data : {
             product_id : product_Id , 
             qty : $('#product' + product_Id).val()
        },
        success : function (result){
            if($('#product' + product_Id).val() <= 0) {
                $('#product' + product_Id).val(0)
                alert('Qty have value > 0');
            } else {
               if(result > 0) {
                  $('#product' + product_Id).val(result);
                  // alert($('#product' + product_Id).val());
                  alert('You have ordered pass limit qty permission is ' + result);                
                } else {
                  $('#result').html(result);  
                }
            }
        }
    });
  }
</script>

