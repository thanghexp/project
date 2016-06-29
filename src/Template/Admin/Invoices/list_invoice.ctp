<fieldset>
	<legend><?php echo __(isset($title) ? $title : ''); ?></legend>
</fieldset>

<table class = "table table-responsive table-stripped">
	<tr class = "bg-primary">
		<th class="text-center">ID</th>
		<th class="text-center">ID Order</th>
		<th class="text-center">Total money</th>
		<th>Create date</th>
		<th class="text-center">Update date</th>
		<th></th>
	</tr>
	<?php foreach($invoices as $invoice) { ?> 
	<tr>
		<td class="text-center" style="font-weight: bold;"><?php echo isset($invoice->invoice_id) ? $invoice->invoice_id : '-'; ?></td>
		<td class="text-center"><?php echo isset($invoice->order_id) ? $invoice->order_id : '-'; ?></td>
		<td class="text-center"><?php echo isset($invoice->total_money) ? '<b>' . number_format($invoice->total_money, 3) . '</b>' : ''; ?></td>
		<td><?php echo (!$invoice->created) ?  '-' : $invoice->created->i18nFormat('yyyy-MM-dd'); ?></td>
		<td class="text-center"><?php echo (!$invoice->updated) ?  '-' : $invoice->updated->i18nFormat('yyyy-MM-dd'); ?></td>
		<td>
			<!-- <a href="<?php echo $this->request->webroot . 'admin/invoices/updateInvoice/'. $invoice->invoice_id; ?>"><img src="<?php echo $this->request->webroot . 'img/edit.png'; ?>" alt="..."></a> -->
			<!-- <a href="<?php echo $this->request->webroot . 'admin/invoices/deleteInvoice/'. $invoice->invoice_id;  ?>" onclick="checkDelete(event)" ><img src="<?php echo $this->request->webroot . 'img/erase.png'; ?>" alt="..."></a> -->
		</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="4" style="font-weight: bold; padding-left: 100px;" class="bg-success">Total money :</td>
		<td colspan="2" class="bg-danger text-center" style="font-weight: bold;"><?php echo isset($invoice_total->sum_total_money) ? number_format($invoice_total->sum_total_money, 3) : ''; ?></td>
	</tr>
</table>

