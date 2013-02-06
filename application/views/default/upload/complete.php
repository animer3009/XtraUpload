<h2 style="vertical-align:middle"><img src="<?=base_url().'img/icons/backup_32.png'?>" class="nb" alt="" /> <?=$this->lang->line('upload_complete_header'); ?></h2>

<p><?=$this->lang->line('upload_complete_message'); ?></p>

	<label><?=$this->lang->line('upload_links_1')?></label>
	<input readonly="readonly" type="text" id="dl_<?=rand()?>" size="50" value="<?=$link['down']?>" onfocus="this.select()" onclick="this.select()" />
	<?php
	
	if(!$this->session->userdata('id'))
	{
	?>
	<br />
	<label><?=$this->lang->line('upload_links_2')?></label>
	<input readonly="readonly" type="text" id="del_<?=rand()?>" size="50" value="<?=$link['del']?>" onfocus="this.select()" onclick="this.select()" />
	<?php
	}
	
	if(isset($link['img']))
	{
		?>
		<br />
		<label><?=$this->lang->line('upload_links_3')?></label>
		<a href="<?=$link['img']?>"><?=$link['img']?></a>
		<?php
	}
?>

<div style="clear:both"></div><br />
<?=generateLinkButton('Upload More Files', site_url('home'), $base_url.'img/icons/back_16.png', 'green')?>