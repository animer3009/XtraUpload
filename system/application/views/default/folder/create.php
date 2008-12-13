<h2 style="vertical-align:middle"><img src="<?=base_url().'img/icons/folder_32.png'?>" class="nb" alt="" /> <?php echo $this->lang->line('folder_create_header')?></h2>

<form action="<?=site_url('folder/process')?>" method="post">
	<p>
	<label for="name"><?php echo $this->lang->line('folder_create_1')?></label>
	<input id="name" size="75" type="text" name="name" />
	
	<label for="desc"><?php echo $this->lang->line('folder_create_2')?></label>
	<textarea id="desc" rows="10" cols="72" name="desc"></textarea><br />

	<label><?php echo $this->lang->line('folder_create_3')?></label>
	<table border="0" width="490" id="file_list_table">
		<tr>
			<th width="300" class="align-left"><?php echo $this->lang->line('folder_create_4')?></th>
			<th width="80"><?php echo $this->lang->line('folder_create_5')?></th>
			<th width="60">Add?<?php echo $this->lang->line('folder_create_6')?> <input type="checkbox" value="ok" name="checkAll" onchange="switchCheckboxes(this.checked)" /></th>
		</tr>
		<?php 
		foreach($files as $id => $file)
		{ 
			?>
			<tr>
				<td><a href='<?=site_url('/files/get/'.$file->file_id.'/'.$file->link_name)?>' target="_blank"><?=$file->o_filename?></a></td>
				<td><?=$this->functions->getFilesizePrefix($file->size)?></td>
				<td>
					<input type="checkbox" class="filec" value="<?=$file->id?>" name="files[]" /> <?php echo $this->lang->line('folder_create_6')?>
				</td>
			</tr>
			<?php 
		}
		?>
	</table>
	<?=generateSubmitButton($this->lang->line('folder_create_7'), base_url().'img/icons/new_16.png')?><br />
	</p>
</form>
<script>
var checkBoxAllBool = false;

function switchCheckboxes()
{
	if(!checkBoxAllBool)
	{
		$('input[@type=checkbox]', document).each(function(i)
		{
			$(this).attr('checked', 'checked');
		});
		checkBoxAllBool = true;
	}
	else
	{
		$('input[@type=checkbox]', document).each(function(i)
		{
			$(this).attr('checked', '');
		});
		checkBoxAllBool = false;
	}
}
</script>