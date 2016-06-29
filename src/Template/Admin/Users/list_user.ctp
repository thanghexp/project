<fieldset>
	<legend><?php echo __(isset($title) ? $title : ''); ?></legend>
</fieldset>
<?php echo $this->Form->create('form'); ?>
<table class = "table table-responsive table-stripped">
	<tr class = "bg-primary">
		<th>ID</th>
		<th>FullName</th>
		<th>Username</th>
		<th>Status</th>
		<th>Address</th>
		<th>Email</th>
		<th>Phone Number</th>
		<th></th>
	</tr>
	<?php foreach($users as $user) { ?> 
	<tr>
		<td class="bg-success"><?php echo isset($user->user_id) ? $user->user_id : ''; ?></td>
		<td><?php echo isset($user->first_name) && isset($user->last_name) ? $user->first_name . ' ' . $user->last_name : ''; ?></td>
		<td><?php echo isset($user->username) ? $user->username : ''; ?></td>
		<td><?php echo $this->Form->input('input', ['name' => 'status[' . $user->user_id . ']', 'label' => FALSE, 'options' => $dropdown, 'type' => 'select', 'default' => $user->status]); ?></td>
		<td><?php echo isset($user->address) ? $user->address : ''; ?></td>
		<td><?php echo (!$user->email) ?  '-' : $user->email; ?></td>
		<td><?php echo (!$user->phone_number) ?  '-' : $user->phone_number; ?></td>
		<td>
			<a href="<?php echo $this->request->webroot . 'admin/users/deleteUser/'. $user->user_id;  ?>"><img src="<?php echo $this->request->webroot . 'img/erase.png'; ?>" alt="..."></a>
		</td>
	</tr>
	<?php } ?>
</table>

<?php echo $this->Form->button(__('Update'), ['class' => 'btn btn-primary', 'style' => 'float: left; margin-left: 15px; ']) ?>
<?php echo $this->Form->end();  ?>

<ul class="pagination">
	<li><?php echo $this->Paginator->first(); ?></li>
	<li><?php echo $this->Paginator->prev(); ?></li>
	<li><?php echo $this->Paginator->numbers(); ?></li>
	<li><?php echo $this->Paginator->next(); ?></li>
	<li><?php echo $this->Paginator->last(); ?></li>

</ul>