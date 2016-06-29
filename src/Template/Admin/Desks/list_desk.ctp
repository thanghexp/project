<fieldset>
	<legend><?php echo isset($title) ? $title : ''; ?></legend>
</fieldset>	
<table class="table table-responsive ">
	<tr class="bg-primary">
		<th>ID</th>
		<th>Name desk</th>
		<th>Number chair</th>
		<th>Create date</th>
		<th>Update date</th>
		<th></th>
	</tr>
	<?php
		if($desks) {
			foreach ($desks as $desk) {
	 ?>
	<tr>
		<td class="bg-success"><?php echo isset($desk->desk_id) ? $desk->desk_id : ''; ?></td>
		<td><?php echo isset($desk->name_desk) ? $desk->name_desk : ''; ?></td>
		<td><?php echo isset($desk->number_chair) ? $desk->number_chair : ''; ?></td>
		<td><?php echo isset($desk->created) ? $desk->created->i18nFormat('yyyy-MM-dd') : '-'; ?></td>
		<td><?php echo isset($desk->updated) ? $desk->updated->i18nFormat('yyyy-MM-dd') : '-'; ?></td>
		<td>
			<a href="<?php echo $this->request->webroot . 'admin/desks/updateDesk/'. $desk->desk_id; ?>"><img src="<?php echo $this->request->webroot . 'img/edit.png'; ?>" alt="..."></a>
			<a href="<?php echo $this->request->webroot . 'admin/desks/deleteDesk/'. $desk->desk_id;  ?>" onclick ="checkDelete(event)"><img src="<?php echo $this->request->webroot . 'img/erase.png'; ?>" alt="..."></a>
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
