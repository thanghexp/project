<div class="row">
  <div class="col-md-12">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="<?php echo $this->request->webroot . 'img/sale_image.jpg'; ?>" style="margin:0px 177px;" width="800" alt="...">
          <div class="carousel-caption">
            ...
          </div>
        </div>
        <div class="item">
          <img src="<?php echo $this->request->webroot . 'img/online-shopping.jpg'; ?>" style="margin:0px 357px;" width="440" alt="...">
          <div class="carousel-caption">
            ...
          </div>
        </div>
        ...
      </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
</div>

<div id="error">
</div>

<div class="row">
  <div><h3 style="background: #dfdfdf;margin-left: 5px; padding: 5px 10px;" >List products new</h3></div>
  <?php foreach($products as $product) { ?>
    <div class="col-sm-6 col-md-3">
      <div class="thumbnail">
        <div style="height: 100px; text-align: center; margin-top: 10px;"><img src="<?php echo $this->request->webroot . $product->image ?>" alt="..." width="150" height="100"/></div>
        <div class="caption" id="<?php echo 'product_id' . $product->product_id; ?>">
          <h3><?php echo isset($product->name_product) ? $product->name_product : ''; ?></h3>
          <p><?php echo '<b>Qty : </b>'  . (isset($product->qty) ? $product->qty  : ''); ?></p>
          <p><?php echo '<b>Price :</b>' . (isset($product->price) ? number_format($product->price, 3) . '  VND' : ''); ?></p>
            <?php 
                if($product->qty > 0) {
                    echo $this->Form->input('order[' . $product->product_id . ']', ['class' => 'form-control', 'label' => false, 'style' => 'width: 70px; float: left;', 'type' => 'number', 'default' => 0, 'id' => 'product' . $product->product_id ]); 
                    echo $this->Form->button(__('Add to cart'), ['class' => 'btn btn-primary', 'id' => 'cart' . $product->id, 'data-target' => '#myModal', 'data-toggle' => 'modal', 'onclick' => 'cart(' . $product->product_id . ')']);
                } else {
                    echo $this->Form->input('order[' . $product->product_id . ']', ['class' => 'form-control', 'label' => false, 'style' => 'width: 70px; float: left;', 'type' => 'number', 'default' => 0, 'id' => 'product' . $product->product_id, 'disabled' => 'true' ]); 
                    echo $this->Form->button(__('Out of stock'), ['class' => 'btn btn-danger', 'disabled' => 'true', 'id' => 'cart' . $product->id, 'onclick' => 'cart(' . $product->product_id . ')']);
                }
             ?>
        </div>
      </div>
    </div>
  <?php } ?>
  <div class="col-md-3" style="margin-top: 150px;">
    <ul class="pager"><li><a href="<?php echo $this->request->webroot . 'products/viewProduct'; ?>">View all products ...  <span aria-hidden="true">&rarr;</span></a></li>
    </ul>
  </div>
</div>



<script type="text/javascript">
  function cart(product_Id) {
    if($('#product' + product_Id).val() <= 0) {
      // $('#myModal').removeClass('in');
      alert('Qty must have > 0 !');
      $('#product' + product_Id).val(0);

    } else {
       // $('#myModal').addClass('fade');  
      $.ajax({
          url : "<?php echo $this->request->webroot . 'products/orderProduct'; ?>",
          type : "post",
          dateType:"text",
          data : {
               product_id : product_Id , 
               qty : $('#product' + product_Id).val()
          },
          success : function (result){
               if(result > 0) {
                  $('#product' + product_Id).val(result);
                  // alert($('#product' + product_Id).val());
                  alert('You have ordered pass limit qty permission is ' + result);                
                } else {
                  $('#result').html(result);  
                }
          }
      });
    }
    
  }
</script>