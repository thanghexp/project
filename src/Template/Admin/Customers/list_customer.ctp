<fieldset>
	<legend><?php echo isset($title) ? $title : ''; ?></legend>
</fieldset>	
<table class="table table-responsive ">
	<tr class="bg-primary">
		<th>ID</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Username</th>
		<th>Address</th>
		<th>Email</th>
		<th>Phone Number</th>
		<th>Create date</th>
		<th>Update date</th>
		<th></th>
	</tr>
	<?php
		if($customers) {
			foreach ($customers as $customer) {
	 ?>
	<tr>
		<td class="bg-success"><?php echo isset($customer->customer_id) ? $customer->customer_id : ''; ?></td>
		<td><?php echo isset($customer->first_name) ? $customer->first_name : ''; ?></td>
		<td><?php echo isset($customer->last_name) ? $customer->last_name : ''; ?></td>
		<td><?php echo isset($customer->username) ? $customer->username : '-'; ?></td>
		<td><?php echo isset($customer->address) ? $customer->address : ''; ?></td>
		<td><?php echo isset($customer->email) ? $customer->email : ''; ?></td>
		<td><?php echo isset($customer->phone_number) ? $customer->phone_number : ''; ?></td>
		<td><?php echo isset($customer->created) ? $customer->created->i18nFormat('yyyy-MM-dd') : '-'; ?></td>
		<td><?php echo isset($customer->updated) ? $customer->updated->i18nFormat('yyyy-MM-dd') : '-'; ?></td>
		<td>
			<a href="<?php echo $this->request->webroot . 'admin/customers/updateCustomer/'. $customer->customer_id; ?>"><img src="<?php echo $this->request->webroot . 'img/edit.png'; ?>" alt="..."></a>
			<a href="<?php echo $this->request->webroot . 'admin/customers/deleteCustomer/'. $customer->customer_id;  ?>" onclick="checkDelete(event)"><img src="<?php echo $this->request->webroot . 'img/erase.png'; ?>" alt="..."></a>
		</td>
	</tr>
	<?php
			}
		} else {	
			echo '<tr><td colspan="5"></td></tr>';
		} 
	?>
</table>



<ul class="pagination">
	<li><?php echo $this->Paginator->first(); ?></li>
	<li><?php echo $this->Paginator->prev(); ?></li>
	<li><?php echo $this->Paginator->numbers(); ?></li>
	<li><?php echo $this->Paginator->next(); ?></li>
	<li><?php echo $this->Paginator->last(); ?></li>
</ul>
