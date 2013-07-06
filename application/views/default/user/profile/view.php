<h2><img src="<?=base_url()?>img/icons/user_32.png" alt="" class="nb" /><?=$this->lang->line('user_view_header'); ?><span><?=ucwords($user->username)?></span></h2>
<div class="userProfile">
	<div>
		<?php if($this->session->userdata('username') == $user->username){?>
			<span class="info"><strong><?=ucwords($user->username)?>:</strong><?=$this->lang->line('user_view_1'); ?><br /><?=$this->lang->line('user_view_2'); ?><a href="<?=site_url('user/manage')?>"></a><?=$this->lang->line('user_view_3'); ?></span>
		<?php }?>
		<h3><img src="<?=base_url()?>img/icons/public_16.png" alt="" class="nb" /><?=$this->lang->line('user_view_header_1'); ?></h3>
		<p>
			<strong><?=$this->lang->line('user_view_4'); ?></strong> <?=ucwords($user->username)?><br />
			<br />
		</p>	
		<h3><img src="<?=base_url()?>img/icons/chart_16.png" alt="" class="nb" /><?=$this->lang->line('user_view_header_2'); ?></h3>
		<?php 		$num = $this->db->get_where('refrence', array('user' => $this->session->userdata('id')))->num_rows();
		?>
		<ul>
			<li style="list-style-image:none;"><strong><?=$this->lang->line('user_view_5'); ?></strong><?=$num?></li>
		</ul>		
	</div>
</div>