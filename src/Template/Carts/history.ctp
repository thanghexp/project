
<table class="table table-responsive" id="result">
  <tr class="bg-primary">
    <th>#</th>
    <th>Order ID</th>
    <!-- <th>Qty</th> -->
    <th>Money</th>
    <th>Create date</th>
  </tr>

  <?php $i = 1; foreach($invoices as $invoice) { ?> 
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo isset($invoice->order_id) ? $invoice->order_id : ''; ?></td>
      <!-- <td><?php //echo isset($invoice->qty) ? $invoice->qty : ''; ?></td> -->
      <td><b><?php echo number_format($invoice->money, 3) . ' VND'; ?></b></td>
      <td><?php echo isset($invoice->created) ? $invoice->created->i18nFormat('yyyy-MM-dd hh:mm') : '-';  ?></td>
    </tr>
  <?php } ?>
</table>

<a href="<?php echo $this->request->webroot . 'products/view-product';  ?>" class="btn btn-default"><span aria-hidden="true">&larr;</span>Back to shopping</a>

<?php echo $this->Form->create('form'); ?>
    <?php echo $this->Form->button(__('Duplicate'), ['class' => 'btn btn-primary', 'style' => 'float:right;']); ?>
    <div class="form-group" style="float:right">
      <?php echo $this->Form->input('order_id', ['options' => $dropdown_date, 'onchange' => 'choseDate()' , 'id' => 'dropdown_date', 'label' => FALSE]); ?>
    </div>
<?php echo $this->Form->end; ?>

<script type="text/javascript">
  function choseDate() {
    $.ajax({
      'url'  : "<?php echo $this->request->webroot . 'carts/data_invoice_history'; ?>",
      'type' : 'POST',
      'dataType' : 'text', 
      'data' : {
                  'order_id' : $('#dropdown_date').val()
              },
      success : function(result) {
          return $('#result').html(result);
      }
    });
      
  }
  
</script>