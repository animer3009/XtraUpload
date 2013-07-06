<h2 style="vertical-align:middle"><img src="<?=base_url().'img/icons/component_32.png'?>" class="nb" alt="" /> Plugin Manager</h2>
<?=$flashMessage?>
<h3><img src="<?=base_url().'img/icons/connect_16.png'?>" class="nb" alt="" /> Installed Plugins</h3>
<table border="0" style="width:99%" id="file_list_table">
	<tr>
		<th class="align-left">Name</th>
		<th>Description</th>
		<th class="align-right" width="14%">Action</th>
	</tr>
	<?phpforeach($installed as $name => $plugin)
	{
		?>			
		<tr <?=alternator('class="odd"', 'class="even"')?>>
			<td>
				<a href="<?=$plugin->link?>" rel="external"><?=$plugin->name?></a> v<?=$this->functions->parseVersion($plugin->version->local, false)?><br />
				By: <a href="<?=$plugin->author->link?>" rel="external"><?=$plugin->author->name?></a>
			</td>
			<td><?=str_replace("\n", '<br />', word_wrap($plugin->description, 60))?></td>
			<td class="align-right">
			
				<?php 
				$active = $this->db->select('active')->get_where('extend', array('file_name' => $name), 1, 0)->row()->active;
				if($active == 1)
				{
					?>
					<a href="<?=site_url('admin/extend/turn_off/'.$name)?>">
						<img src="<?=$base_url?>img/icons/on_16.png" alt="" class="nb" />
					</a>
					<?php
				}
				else
				{
					?>
					<a href="<?=site_url('admin/extend/turn_on/'.$name)?>">
						<img src="<?=$base_url?>img/icons/off_16.png" alt="" class="nb" />
					</a>
					<?php
				}
				?>
				
				<?php
				if($this->startup->site_config['allow_version_check'] and isset($plugin->version->latest_link))
				{
					$latest_version = @file_get_contents($plugin->version->latest_link);
					if($plugin->version->local < $latest_version and $latest_version != false)
					{
						?>
						<a href="<?=$plugin->version->download_link?>" rel="external">
							<img src="<?=$base_url?>img/icons/certificate_16.png" alt="" class="nb" title="New Version Available: v<?=$this->functions->parseVersion($latest_version, false)?>" />
						</a>
						<?php
					}
				}
				?>
				
				<a href="<?=site_url('admin/extend/remove/'.$name)?>">
					<img src="<?=$base_url?>img/icons/trash_16.png" alt="" class="nb" />
				</a>
				
			</td>
		</tr>
		<?php
	}
	?>
</table>

<h3><img src="<?=base_url().'img/icons/disconnect_16.png'?>" class="nb" alt="" /> Not Installed Plugins</h3>
<table border="0" style="width:99%" id="file_list_table">
	<tr>
		<th class="align-left">Name</th>
		<th>Description</th>
		<th class="align-right" width="11%">Action</th>
	</tr>
	<?php foreach($not_installed as $name => $plugin)
	{
		?>			
		<tr <?=alternator('class="odd"', 'class="even"')?>>
			<td>
				<a href="<?=$plugin->link?>" rel="external"><?=$plugin->name?></a> v<?=$this->functions->parseVersion($plugin->version->local, false)?><br />
				By: <a href="<?=$plugin->author->link?>" rel="external"><?=$plugin->author->name?></a>
			</td>
			<td><?=str_replace("\n", '<br />', word_wrap($plugin->description, 60))?></td>
			<td class="align-right">
				<a href="<?=$plugin->link?>" rel="external" title="Visit Plugin Home Page">
					<img src="<?=$base_url?>img/icons/link_16.png" alt="" class="nb" />
				</a>
				<a href="<?=site_url('admin/extend/install/'.$name)?>" title="Install Plugin">
					<img src="<?=$base_url?>img/icons/wizard_16.png" alt="" class="nb" />
				</a>
			</td>
		</tr>
		<?php 	}
	?>
</table>