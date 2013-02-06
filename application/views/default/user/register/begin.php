<h2 style="vertical-align:middle"><img src="<?=$base_url.'img/icons/user_32.png'?>" class="nb" alt="" /> <?=$this->lang->line('user_register_begin_header')?></h2>
<?=$errorMessage?>
<form action="<?=site_url('user/register')?>" method="post" id="user_reg">
	<input type="hidden" name="posted" value="1" />
	
    <label style="font-weight:bold" for="username"><?=$this->lang->line('user_register_begin_1')?></label>
	<input type="text" class="required remove_title" minlength="5" name="username" value="<?=set_value('username');?>" size="50" /><br /><br />
	
	<label style="font-weight:bold" for="group"><?=$this->lang->line('user_register_begin_2')?>, <a href="<?=site_url('user/compare')?>" rel="external"><?=$this->lang->line('user_register_begin_3')?></a></label>
	<select name="group" id="group_sel" onchange="isPaidGroup(this.value)">
		<?php
		$bs = array(
			'0' => $this->lang->line('user_register_begin_4'),
			'd' => $this->lang->line('user_register_begin_5'),
			'w' => $this->lang->line('user_register_begin_6'),
			'm' => $this->lang->line('user_register_begin_7'),
			'y' => $this->lang->line('user_register_begin_8'),
			'dy' => $this->lang->line('user_register_begin_9'),
		);
		$script = array();
		foreach($groups->result() as $group)
		{
			if($group->id == 2 or $group->id == 1)
			{
				continue;
			}
			
			$script[$group->id] = false;
			if($group->price > 0.00)
			{
				$script[$group->id] = true;
			}
			?>
			<option value="<?=$group->id?>">
				<?=ucwords($group->name)?>&nbsp;(<?php if($group->price > 0.00){echo '$'.$group->price.$this->lang->line('user_register_begin_10').$bs[$group->repeat_billing];}else{echo $this->lang->line('user_register_begin_11');}?>)&nbsp;
			</option>
			<?php
		}
		?>
	</select><br /><br />
	<script type="text/javascript">	
	$(document).ready(function()
	{
		isPaidGroup($('#group_sel').val());
	});
	
	function isPaidGroup(id)
	{
		var groups = new Array();
		<?php foreach($script as $id => $paid)
		{
		?>groups[<?=$id?>] = <?=$paid?>;
		<?php
		}
		?>
		if(groups[id])
		{
			$('#payment_gate').slideDown('normal');
		}
		else
		{
			$('#payment_gate').slideUp('normal');
		}
	}
	</script>
	
	<div style="display:none" id="payment_gate">
		<label style="font-weight:bold" for="group"><?=$this->lang->line('user_register_being_payment_method'); ?></label>
		<select name="gate">
			<?php
			foreach($gates->result() as $gate)
			{
				?>
				<option <?php if($gate->default == 1){?> selected="selected"<?php }?> value="<?=$gate->id?>"><?=ucwords($gate->display_name);?></option>
				<?php
			}
			?>
		</select><br /><br />
	</div>

    <label style="font-weight:bold" for="email"><?=$this->lang->line('user_register_begin_12')?></label>
    <input type="text" class="required email remove_title" name="email" value="<?=set_value('email');?>" size="50" /><br />
	
	<label style="font-weight:bold" for="email"><?=$this->lang->line('user_register_begin_13')?></label>
    <input type="text" class="required email remove_title" name="emailConf" value="<?=set_value('emailConf');?>" size="50" /><br /><br />

    <label style="font-weight:bold" for="password"><?=$this->lang->line('user_register_begin_14')?></label>
    <input type="password" class="required remove_title" name="password" value="<?=set_value('password');?>" size="50" /><br />
    
    <label style="font-weight:bold" for="passconf"><?=$this->lang->line('user_register_begin_15')?></label>
    <input type="password" class="required remove_title" name="passconf" value="<?=set_value('passconf');?>" size="50" /><br /><br />

    
    <label style="font-weight:bold" for="captcha"><?=$this->lang->line('user_register_begin_16')?></label>
    <?=$captcha?><br />
	<input type="text" class="required remove_title" name="captcha" /><br /><br />
    
    <?=generateSubmitButton($this->lang->line('user_register_begin_17'), base_url().'img/other/user-add_16.png')?><br />
</form>
<script type="text/javascript">
$(document).ready(function(){
	$("#user_reg").validate();
});
</script>