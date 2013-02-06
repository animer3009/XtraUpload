<?php

if(isset($link['failed']) and $link['failed'] == true)
{
    echo $this->lang->line('upload_links_4').'<br /> Reason: '.$link['reason'];
}
elseif($link)
{
	?>
	<?=$this->lang->line('upload_links_1')?><input readonly="readonly" type="text" id="dl_<?=rand()?>" size="50" value="<?=$link['down']?>" onfocus="this.select()" onclick="this.select()" />
	<?php
	
	if(!$this->session->userdata('id'))
	{
	?>
	<br />
	<?=$this->lang->line('upload_links_2')?><input readonly="readonly" type="text" id="del_<?=rand()?>" size="50" value="<?=$link['del']?>" onfocus="this.select()" onclick="this.select()" />
	<?php
	}
	
	if(isset($link['img']))
	{
		?>
		<br />
		<?=$this->lang->line('upload_links_3')?><a href="<?=$link['img']?>"><?=$link['img']?></a>
		<?php
	}
}
else
{
	echo $this->lang->line('upload_links_4');
}
?>