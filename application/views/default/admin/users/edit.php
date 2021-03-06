<h2 style="vertical-align:middle"><img src="<?=base_url().'img/icons/user_32.png'?>" class="nb" alt="" /> User - Edit</h2><br />
<?=$error?>
<?=generateLinkButton('Manage Users', site_url('admin/user/home'), base_url().'img/icons/back_16.png')?><br />
<form action='<?=site_url('admin/user/edit/'.$user->id)?>' method="post">
	<h3>Edit User: <?=$user->username?></h3>
    <p>
        <label style="font-weight:bold" for="username">Username</label>
		<input type="text" name="username" value="<?=(set_value('username') ? set_value('username') : $user->username)?>" size="50" /><br />
    
        <label style="font-weight:bold" for="realname">Email</label>
        <input type="text" name="email" value="<?=(set_value('email') ? set_value('email') : $user->email)?>" size="50" /><br />
		
		<label style="font-weight:bold" for="realname">User Group</label>
		<select name="group">
			<?php
			foreach($groups->result() as $group)
			{
				?>
				<option <?php if($group->id == $user->group){?> selected="selected"<?php }?> value="<?=$group->id?>"><?=ucwords($group->name)?></option>
				<?php
			}
			?>
		</select>
    
        <label style="font-weight:bold" for="realname">New Password</label>
        <input type="text" name="password" value="<?=set_value('password')?>" size="50" /><br /><br />

		<?=generateSubmitButton('Submit Changes', base_url().'img/icons/ok_16.png', 'green')?><br />
    </p>
</form>