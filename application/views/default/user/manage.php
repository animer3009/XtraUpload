<?php if(!$this->session->userdata('id'))redirect('home');?>
<h2><img src="<?=base_url()?>img/icons/user_32.png" alt="" class="nb" /><?=$this->lang->line('user_manage_header')?></span></h2>

<?=$errorMessage?>

<form action='<?=site_url('user/manage')?>' method="post">
	<h3><?=$this->lang->line('user_manage_1')?></h3>
    <p>
        <label style="font-weight:bold" for="username"><?=$this->lang->line('user_manage_2')?></label>
        <input type="text" class="readonly" readonly="readonly" name="username" value="<?=$this->session->userdata('username')?>" size="50" /><br /><br />
        
		<? //generateSubmitButton($this->lang->line('user_manage_3'), base_url().'img/icons/ok_16.png', 'green').'<br />'?>
    </p>
</form>