<h2 style="vertical-align:middle"><img src="<?=base_url().'img/icons/credit_card_32.png'?>" class="nb" alt="" /> Payment Gateways </h2>
<?=$flashMessage?>
<table class="special" border="0" id="gateway_list_table" cellspacing="0" style="width:98%">
	<tr>
		<th class="align-left">
				Name
		</th>
		<th>
			Actions
		</th>
	</tr>
	<?php foreach($gates->result() as $gate)
	{
		?>			
		<tr <?=alternator('class="odd"', 'class="even"')?>>
			<td>
				<?=$gate->display_name?>
			</td>
			<td>
				<?php
				if($gate->status)
				{
					?>
					<a title="Disable Gateway" href="<?=site_url('admin/gateways/turn_off/'.$gate->id)?>">
						<img src="<?=base_url()?>img/icons/on_16.png" class="nb" alt="Disable" />
					</a>
					<?php
				}
				else
				{
					?>
					<a title="Enable Gateway" href="<?=site_url('admin/gateways/turn_on/'.$gate->id)?>">
						<img src="<?=base_url()?>img/icons/off_16.png" class="nb" alt="Enable" />
					</a>
					<?php
				}
				?>
				
				<?php
				if($gate->default)
				{
					?>
						<img src="<?=base_url()?>img/icons/certificate_16.png" class="nb" alt="Current Default!" />
					<?php
				}
				else
				{
					?>
					<a title="Edit This File" href="<?=site_url('admin/gateways/set_default/'.$gate->id)?>">
						<img src="<?=base_url()?>img/icons/new_16.png" class="nb" alt="Set To Default" />
					</a>
					<?php
				}
				?>
				<a title="Edit This File" href="<?=site_url('admin/gateways/edit/'.$gate->id)?>">
					<img src="<?=base_url()?>img/icons/edit_16.png" class="nb" alt="Edit" />
				</a>
			</td>
		</tr>
		<?php 	}
	?>
</table>