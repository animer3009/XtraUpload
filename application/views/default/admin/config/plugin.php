<h2 style="vertical-align:middle"><img src="<?=base_url().'img/icons/options_32.png'?>" class="nb" alt="" /> Plugin Config Settings</h2>
<?=$flashMessage?>
<form method="post" action="<?=site_url('admin/config/update')?>">
	<h3><?=ucwords(str_replace('_',' ', $name))?> Config</h3>
	<table width="500" border="0">
		<?php
		$this->load->helper('string');
		
		if($num_rows <= 0)
		{
		    ?><span class="alert">No Config Settings for this plugin.</span><?php
		}
		else
		foreach($configs->result() as $config)
		{
			?>
			<tr <?=alternator('class="odd"', 'class="even"')?>>
				<td width="150"><?=$config->description1?></td>
				<td width="350">
					<?php
					if($config->type == 'text')
					{
						?>
						<input type="text" name="<?=$config->name?>" id="<?=$config->name?>" value="<?=$config->value?>" />
						<img src="<?=$base_url?>/img/icons/about_16.png" style="cursor:pointer" onclick="$('#d_<?=$config->name?>').slideToggle()" class="nb" />
						<span style="display:none" id="d_<?=$config->name?>"><?=$config->description2?></span>
						<?php
					}
					else if($config->type == 'box')
					{
						?>
						<textarea rows="8" cols="40" name="<?=$config->name?>" id="<?=$config->name?>" ><?=$config->value?></textarea>
						<img src="<?=$base_url?>/img/icons/about_16.png" style="cursor:pointer" onclick="$('#d_<?=$config->name?>').slideToggle()" class="nb" />&nbsp;<span style="display:none" id="d_<?=$config->name?>"><?=$config->description2?></span>
						<?php
					}
					else if($config->type == 'color')
					{
						?>
						<div id="color_<?=$config->id?>"></div>
						<input type="text" name="<?=$config->name?>" value="<?=$config->value?>" id="<?=$config->name?>" \>
						<?=$config->description2?>
						<script>
						$("#color_<?=$config->id?>").farbtastic('<?=$config->name?>','<?=$config->value?>');
						$("#color_<?=$config->id?>").css('background-color','<?=$config->value?>');
						</script><br />
						<?php
					}
					else
					{
						$description = $config->description2;
						$description = explode('|-|',$description);
						?>
						<input type="radio" name="<?=$config->name?>" id="<?=$config->name?>" value="1"<?php if($config->value == '1'){?> checked="checked"<?php } ?> />
						<?=$description[0]?><br />
						
						<input type="radio" name="<?=$config->name?>" id="<?=$config->name?>" value="0"<?php if($config->value == '0'){?> checked="checked"<?php } ?> />
						<?=$description[1]?><br />
					<?php
					}
					?>
				</td>
			</tr>
			
		<?php
		}
		?>
	</table>
	<input type="hidden" name="valid" value="yes" />
	<?php
	if($num_rows > 0)
	{
	    echo generateSubmitButton('Update', base_url().'img/icons/ok_16.png', 'green');
	}
	else
	{
	    echo generateLinkButton('Go Back', 'javascript:history.go(-1)', base_url().'img/icons/back_16.png');
	}
	?><br />
</form>