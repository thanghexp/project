<fieldset>
  <legend><?php echo __('List products that customer ordered !'); ?></legend>
</fieldset>

<div class="row" > 
    <div class="container" style="margin: 10px 0px; padding: 0px 0px 10px;">
     <h3 style="margin: 0px 20px; float:left;">
          Code ID : 
          <b style="border:2px solid red; margin-top: 20px">
              <?php echo isset($orders->code_order) ? $orders->code_order : ''; ?>
          </b>
      </h3>
      <h4 style="margin: 0px 20px; float:right;">
          Date : 
              <?php echo isset($orders->created) ? $orders->created->i18nFormat('yyyy-MM-dd hh:mm') : ''; ?>
      </h4>
    </div>
  <?php if($info['full_name']) { ?>
      <ul style="font-size: 20px;list-style: none; margin-left:-160px;">
        <li class="col-md-5 col-md-offset-2"><b>Full name: </b><?php echo isset($info['full_name']) ? $info['full_name'] : ''; ?> </li>
        <li class="col-md-5"><b>Address :</b><?php echo isset($info['customer']['address']) ? $info['customer']['address'] : ''; ?> </li>
        <li class="col-md-5 col-md-offset-2"><b>Phone number : </b> <?php echo isset($info['customer']['phone_number']) ? $info['customer']['phone_number'] : ''; ?> </li>
        <li class="col-md-5"><b>Email: </b><?php echo isset($info['customer']['email']) ? $info['customer']['email'] : ''; ?> </li>
      </ul>
  <?php } ?>
</div>

<?php echo $this->Form->create('form', ['url' => '/rows/updateCart']); ?>
<table class="table table-responsive" id="result">
  <tr class="bg-primary">
    <th>#</th>
    <th>Name product</th>
    <th>Qty</th>
    <th>Money</th>
    <th></th>
  </tr>

  <?php $i = 1; foreach($order_products as $row) { ?> 
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo isset($row->product->name_product) ? $row->product->name_product : ''; ?></td>
      <td><?php echo isset($row->qty) ? $row->qty : ''; ?></td>
      <td><?php echo number_format($row->product->price * $row->qty, 3) . ' VND'; ?></td>
      <td></td>
    </tr>
  <?php } ?>
  <tr><td colspan="4" class="bg-success">Total money :</td><td class="bg-danger"><b><?php echo isset($sum_money) ? number_format($sum_money, 3) . ' VND' : ''; ?></b></td></tr>
</table>
<?php echo $this->Form->end; ?>

<!-- <a href="<?php echo $this->request->webroot . 'products/view-product';  ?>" class="btn btn-default"><span aria-hidden="true">&larr;</span>Back to shopping</a> -->

<a href="<?php echo $this->request->webroot . 'admin/orders/listOrder';  ?>" style="float:right;" class="btn btn-success"><b>Done</b></a>