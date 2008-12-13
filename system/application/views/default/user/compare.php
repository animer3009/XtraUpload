<h2 style="vertical-align:middle"><img src="<?=$base_url.'img/icons/user_32.png'?>" class="nb" alt="" /> <?php echo $this->lang->line('user_compare_header')?></h2>
<p>
	<?php echo $this->lang->line('user_compare_1')?>
<table border="0" style="width:98%">
	<?php
	$i=0;
	$names = array(
		'speed_limit' => $this->lang->line('user_compare_2'),
		'upload_size_limit' => $this->lang->line('user_compare_3'),
		'wait_time' => $this->lang->line('user_compare_4'),
		'download_captcha' => $this->lang->line('user_compare_5'),
		'auto_download' => $this->lang->line('user_compare_6'),
		'upload_num_limit' => $this->lang->line('user_compare_7'),
		'storage_limit' => $this->lang->line('user_compare_8'),
		'repeat_billing' => $this->lang->line('user_compare_9'),
		'price' => $this->lang->line('user_compare_10'),
		'file_expire' => $this->lang->line('user_compare_11'),
	);
	$skip = array('id', 'status', 'descr', 'files_types', 'file_types_allow_deny', 'admin');
	foreach($group1 as $name => $value)
	{
		if(in_array($name, $skip)){continue;}
		?>
		<tr>
			<?php
			if($i==0)
			{
				?><th><?php echo $this->lang->line('user_compare_12')?></th><?php
				$i++;
			}
			else
			{
				?><td><?php echo $names[$name]?></td><?
			}
			
			$groups = $this->db->select($name)->get_where('groups', array('id !=' => 2, 'id !=' => 1, 'status' => '1'));
			foreach($groups->result() as $group)
			{
				
				if($name == 'name')
				{
					?><th><?php echo $group->$name?></th><?php
				}
				else if($name == 'wait_time')
				{
					?><td><?php echo $group->$name?><?php echo $this->lang->line('user_compare_13')?></td><?php 
				}
				else if($name == 'file_expire')
				{
					?><td><?php echo $group->$name?><?php echo $this->lang->line('user_compare_14')?></td><?php 
				}
				else if($name == 'price')
				{
					?><td><?php if($group->$name <= 0.00){echo $this->lang->line('user_compare_15');}else{echo '$'.$group->$name;}?></td><?php 
				}
				else if($name == 'download_captcha')
				{
					?><td><?php if($group->$name){?><?php echo $this->lang->line('user_compare_16')?><?php }else{?><?php echo $this->lang->line('user_compare_17')?><?php }?></td><?php 
				}
				else if($name == 'auto_download')
				{
					?><td><?php if($group->$name){?><?php echo $this->lang->line('user_compare_16')?><?php }else{?><?php echo $this->lang->line('user_compare_17')?><?php }?></td><?php 
				}
				else if($name == 'speed_limit')
				{
					?><td><?php echo $group->$name?><?php echo $this->lang->line('user_compare_18')?></td><?php 
				}
				else if($name == 'repeat_billing')
				{
					$bs = array(
						'' => $this->lang->line('user_compare_19'),
						'0' => $this->lang->line('user_compare_20'),
						'd' => $this->lang->line('user_compare_21'),
						'w' => $this->lang->line('user_compare_22'),
						'm' => $this->lang->line('user_compare_23'),
						'y' => $this->lang->line('user_compare_24'),
						'dy' => $this->lang->line('user_compare_25'),
					);,
					?><td><?php echo $bs[$group->repeat_billing]?></td><?php 
				}
				else if($name == 'upload_size_limit')
				{
					?><td><?php echo $group->$name?><?php echo $this->lang->line('user_compare_26')?></td><?php 
				}
				else if($name == 'storage_limit')
				{
					if(intval($group->$name == 0))
					{
						$group->$name = $this->lang->line('user_compare_27');
					}
					?><td><?php echo $group->$name?><?php echo $this->lang->line('user_compare_26')?></td><?php 
				}
				else if($name == 'upload_num_limit')
				{
					?><td><?php echo $group->$name?><?php echo $this->lang->line('user_compare_28')?></td><?php 
				}
				?>
			<?php 
			}
			?>
		</tr>
	<?php 
	}
	?>
</table>
</p>