<h2 style="vertical-align:middle"><img src="<?=base_url().'img/icons/folder_32.png'?>" class="nb" alt="" /> <?=$this->lang->line('folder_view_header')?></h2>
<h3><?=$this->lang->line('folder_view_1')?><?=$folder->name?></h3>
<pre><code><?=$folder->descr?></code></pre>
<div id="folder">
<table border="0" style="width:100%" id="file_list_table">
	<tr>
		<th class="align-left"><?=$this->lang->line('folder_view_2')?></th>
		<th><?=$this->lang->line('folder_view_3')?></th>
	</tr>
	<?php foreach($folder_files->result() as $fileRef)
	{
		$file = $this->files_db->_getFileObject($fileRef->file_id);
		$links = $this->files_db->getLinks('', $file);
		?>			
		<tr>
			<td>
				<img src="<?=base_url().'img/files/'.$this->functions->getFileTypeIcon($file->type);?>" class="nb" alt="" />
				<a href='<?=site_url('/files/get/'.$file->file_id.'/'.$file->link_name)?>' target="_blank"><?=$file->o_filename?></a>
			</td>
			<td><?=$this->functions->getFilesizePrefix($file->size)?></td>
		</tr>
		<?php 	}
	?>
</table>
</div>