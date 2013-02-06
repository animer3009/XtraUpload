<h2 style="vertical-align:middle"><img src="<?=base_url().'img/icons/edit_32.png'?>" class="nb" alt="" /> Edit Transaction</h2>
<?=$flashMessage?>
<form method="post" action="<?=site_url('admin/transactions/update/'.$transaction->id)?>">
	<h3>Transaction Info</h3>
	<?php
	$set = unserialize($transaction->settings);
	$config = unserialize($transaction->config);
	
	foreach($config as $name => $type)
	{
		if($type == 'text')
		{
			?>
			<label><?=ucwords(str_replace('_', ' ', $name))?></label>
			<input type="text" name="<?=$name?>" id="<?=$name?>" value="<?=$set[$name]?>" /><br /><br />
			<?php
		}
		else if($type == 'box')
		{
			?>
			<label><?=ucwords(str_replace('_', ' ', $name))?></label>
			<textarea rows="8" cols="40" name="<?=$name?>" id="<?=$name?>" ><?=$set[$name]?></textarea><br /><br />
			<?php
		}
	}
	?>
	<input type="hidden" name="valid" value="yes" />
	<?=generateSubmitButton('Update', $base_url.'img/icons/ok_16.png', 'green')?><br />
</form>