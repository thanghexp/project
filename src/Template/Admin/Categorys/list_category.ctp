
<fieldset>
	<legend><?php echo isset($title) ? $title : ''; ?></legend>
</fieldset>	
<table class="table table-responsive ">
	<tr class="bg-primary">
		<th>ID</th>
		<th>Name Category</th>
		<th>Create date</th>
		<th>Update date</th>
		<th></th>
	</tr>
	<?php
		if($categorys) {
			foreach ($categorys as $category) {
	 ?>
	<tr>
		<td><?php echo isset($category->category_id) ? $category->category_id : ''; ?></td>
		<td><?php echo isset($category->name_category) ? $category->name_category : ''; ?></td>
		<td><?php echo isset($category->created) ? $category->created->i18nFormat('yyyy-MM-dd') : '-'; ?></td>
		<td><?php echo isset($category->updated) ? $category->updated->i18nFormat('yyyy-MM-dd') : '-'; ?></td>
		<td>
			<a href="<?php echo $this->request->webroot . 'admin/categorys/updateCategory/'. $category->category_id; ?>"><img src="<?php echo $this->request->webroot . 'img/edit.png'; ?>" alt="..."></a>
			<a href="<?php echo $this->request->webroot . 'admin/categorys/deleteCategory/'. $category->category_id;  ?>" onclick="checkDelete(event)"><img src="<?php echo $this->request->webroot . 'img/erase.png'; ?>" alt="..."></a>
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
