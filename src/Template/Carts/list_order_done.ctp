
<h3>Code ID : <b style="border:2px solid red"><?php echo isset($code_id) ? $code_id : ''; ?></b></h3>

<?php echo $this->Form->create('form', ['url' => '/invoices/updateCart']); ?>
<table class="table table-responsive" id="result">
  <tr class="bg-primary">
    <th>#</th>
    <th>Name product</th>
    <th>Qty</th>
    <th>Money</th>
    <th>Create date</th>
  </tr>

  <?php $i = 1; foreach($order_products as $invoice) { ?> 

    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo isset($invoice->product->name_product) ? $invoice->product->name_product : ''; ?></td>
      <td><?php echo isset($invoice->qty) ? $invoice->qty : ''; ?></td>
      <td><?php echo number_format($invoice->product->price * $invoice->qty, 3) . ' VND'; ?></td>
      <td><?php echo isset($invoice->created) ? $invoice->created->i18nFormat('yyyy-MM-dd hh:mm') : '-';  ?></td>
    </tr>
  <?php } ?>
  <tr><td colspan="4" class="bg-success">Total money :</td><td class="bg-danger"><b><?php echo isset($sum_money) ? number_format($sum_money, 3) . ' VND' : ''; ?></b></td></tr>
</table>
<?php echo $this->Form->end; ?>

<!-- <a href="<?php echo $this->request->webroot . 'products/view-product';  ?>" class="btn btn-default"><span aria-hidden="true">&larr;</span>Back to shopping</a> -->

<a href="<?php echo $this->request->webroot . 'products/view-product';  ?>" style="float:right;" class="btn btn-success"><b>Done</b></a>