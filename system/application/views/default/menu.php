<?php
if($this->session->userdata('id'))
{
?>
	<h3><?php echo $this->lang->line('global_welcome')?> <?=$this->session->userdata('username')?>!</h3>
	<ul class="sidemenu">
		<li>
			<a href="<?=site_url('user/manage')?>">
				<img src="<?=$base_url?>img/fam/application_form.png" class="nb" alt="" /> <?php echo $this->lang->line('global_manage')?>
			</a>
		</li>
		<li>
			<a href="<?=site_url('user/changePassword')?>">
				<img src="<?=$base_url?>img/other/key_16.png" class="nb" alt="" /> <?php echo $this->lang->line('global_change')?>
			</a>
		</li>
		<li>
			<a href="<?=site_url('user/logout')?>">
				<img src="<?=$base_url?>img/icons/log_out_16.png" class="nb" alt="" /> <?php echo $this->lang->line('global_logout')?>
			</a>
		</li>
	</ul>
<?
}
else
{
?> 
	<h3><?php echo $this->lang->line('global_member_login')?> </h3>
	<form action="<?=site_url('user/login')?>" method="post" class="loginform">
	<p>
		<label for="username"><b><?php echo $this->lang->line('global_username')?> </b></label>
		<input style="background:2px center url(<?=$base_url?>img/icons/user_16.png) no-repeat transparent; padding-left:22px" type="text" id="username" name="username" />
		
		<label for="password"><b><?php echo $this->lang->line('global_password')?> </b></label>
		<input style="background:2px center url(<?=$base_url?>img/other/key_16.png) no-repeat transparent; padding-left:22px" type="password" id="password" name="password"  /><br /><br />
		<?=generateSubmitButton($this->lang->line('global_login'), $base_url.'img/icons/log_in_16.png', 'green')?><br />
		</p>
	</form>
	<ul class="sidemenu">
		<li>
			<a href="<?=site_url('user/forgotPassword')?>">
				<img src="<?=$base_url?>img/icons/help_16.png" class="nb" alt="" /> <?php echo $this->lang->line('global_forgot_pass')?>
			</a>
		</li>
		<li>
			<a href="<?=site_url('user/register')?>">
				<img src="<?=$base_url?>img/other/user-add_16.png" class="nb" alt="" /> <?php echo $this->lang->line('global_new_user')?>
			</a>
		</li>
	</ul>
<?php
}	
?>

<?php echo $this->xu_api->menus->getSubMenu();?>

<?php
/*
if(stristr($this->uri->uri_string(),'/blog'))
{
?>
	<h3>Blog Navigation</h3>
	<ul class="sidemenu">
		<li><a class="home" href="<?=site_url('/blog/index')?>"><img src="<?=$base_url?>img/other/home2_16.png" class="nb" alt="" />Home</a></li>
		
		<li><h4>Recent Entries</h4></li>
		<? foreach($this->blog_db->getRecentEntries(5) as $ent):?>
		<li>
			<a class="note" href="<?=site_url('/blog/view/'.$ent['id'].'/'.url_title($ent['title']))?>">
				<img src="<?=$base_url?>img/icons/comments_16.png" class="nb" alt="" /><?=$ent['title']?>
			</a>
		</li>
		<? endforeach;?>

		<li><h4>Categories</h4></li>
		<? foreach($this->blog_db->getCategories() as $cat):?>
		<li><a class="record" href="<?=site_url('/blog/category/'.$cat['name'])?>">
		<img src="<?=$base_url?>img/icons/tags_16.png" class="nb" alt="" /><?=ucwords($cat['name'])?>
		</a></li>
		<? endforeach;?>
	</ul>
<?php
}
?>


<?php 
if(stristr($this->uri->uri_string(),'/news'))
{
?>
	<h3>News Navigation</h3>
	<ul class="sidemenu">
		<li><a class="home" href="<?=site_url('/news/index')?>"><img src="<?=$base_url?>img/other/home2_16.png" class="nb" alt="" />Home</a></li>
		
		<li><h4>Recent Entries</h4></li>
		<? foreach($this->news_db->getRecentEntries(5) as $ent):?>
		<li>
			<a class="note" href="<?=site_url('/news/view/'.$ent['id'].'/'.url_title($ent['title']))?>">
				<img src="<?=$base_url?>img/icons/comments_16.png" class="nb" alt="" /><?=$ent['title']?>
			</a>
		</li>
		<? endforeach;?>

		<li><h4>Categories</h4></li>
		<? foreach($this->news_db->getCategories() as $cat):?>
		<li><a class="record" href="<?=site_url('/news/category/'.$cat['name'])?>">
		<img src="<?=$base_url?>img/icons/tags_16.png" class="nb" alt="" /><?=ucwords($cat['name'])?>
		</a></li>
		<? endforeach;?>
	</ul>
<?php
}
*/
?>