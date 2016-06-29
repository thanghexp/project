<div class="form-group">
  <?php echo $this->Form->input('duplicate_cart', ['options' => $dropdown_date, 'type' => 'select', 'label' => FALSE]); ?>
</div>

<div class="form-group">
  <?php echo $this->Form->input('duplicate_cart', ['options' => ['1' => 'Before 1 day'], 'type' => 'select', 'label' => FALSE]); ?>
</div>
<?php echo $this->Form->create('form', ['url' => '/invoices/updateCart']); ?>
<table class="table table-responsive" id="result">
  <tr class="bg-primary">
    <th>Auto number</th>
    <th>Name invoice</th>
    <th>Qty</th>
    <th>Money</th>
    <th>Create date</th>
  </tr>

  <?php $i = 1; foreach($invoices as $invoice) { ?> 
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo isset($invoice->product->name_product) ? $invoice->product->name_product : ''; ?></td>
      <td><?php echo isset($invoice->qty) ? $invoice->qty : ''; ?></td>
      <td><?php echo number_format($invoice->product->price * $invoice->qty, 3) . ' VND'; ?></td>
      <td><?php echo isset($invoice->created) ? $invoice->created->i18nFormat('yyyy-MM-dd') : '-';  ?></td>
    </tr>
  <?php } ?>
</table>
<?php echo $this->Form->end; ?>

<a href="<?php echo $this->request->webroot . 'products/view-product';  ?>" class="btn btn-default"><span aria-hidden="true">&larr;</span>Back to shopping</a>
<a href="<?php echo $this->request->webroot . 'products/view-product';  ?>" style="float:right;" class="btn btn-primary">Send</a>