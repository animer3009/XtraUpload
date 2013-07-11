<div style="margin:auto; text-align:center"><h1>Filesystem And Version Check</h1></div>
<div class="progressMenu">
	<ul>
		<li class="complete"><a href="index.php?c=install&m=step1"><img src="../img/icons/ok_16.png" border="0" alt="" /> Step 1</a></li>
		<li>&raquo;</li>
		<li class="current"><img src="../img/icons/about_16.png" border="0" alt="" /> Step 2</li>
		<li>&raquo;</li>
		<li>Step 3</li>
		<li>&raquo;</li>
		<li>Step 4</li>
		<li>&raquo;</li>
		<li> Step 5</li>
	</ul>
</div>
<div class='centerbox'>
	<div class='tableborder'>
		<div class='maintitle'>Server Test Results</div>
		<div class='pformstrip'>This section outputs the results of a series of tests to ensure everything is configured correctly before installing.</div>
		<table width='100%' cellspacing='1' id='perms'>
		<tr>
			<td class='pformleftw'><span style="font-size:20px; font-weight:bold">Permission Checks</span></td>
			<td class='pformright'>&nbsp;</td>
		</tr>

        <?php foreach($chmod as $filePath => $octet): ?>

		  <tr>
			<td class='pformleftw'>
				<strong>
					File: <?=$filePath?><br>
					Permissions Required: <?=$octet?><br>
				</strong>
			</td>
			<td class='pformright'>

                <?php if(is_writable($filePath)): $is_chmod = false; ?>
                    <b style="color:#009900;font-size:18px;">Passed</b>
                <?php else: ?>
                    <b style="color:#FF0000;font-size:18px;">Failed</b>
                <?php endif; ?>

			</td>
		  </tr>

        <?php endforeach; ?>
		<tr>
			<td class='pformleftw'><span style="font-size:20px; font-weight:bold">Version Checks</span></td>
			<td class='pformright'>&nbsp;</td>
		</tr>
		<tr>
			<td class='pformleftw'>
				PHP Version<br>
				Minimum Version: <strong>v5.3.3</strong><br>
				Version Found: <strong>v<?php echo phpversion()?></strong>
			</td>
			<?php if(version_compare(phpversion(), '5.3.3', '>')): ?>
                <td class='pformright'>
                    <font color="#009900" size="4"><strong>Passed</strong></font>
                </td>
			<?php else: $is_chmod = false; ?>
                <td class='pformright'>
                    <font color="#FF0000" size="4">
                        <strong>
                            Failed
                        </strong>
                    </font><br />
                    Please update PHP to the latest version in the <a href="http://php.net/downloads.php" target="_blank">v5.3 code branch</a>
                </td>
			<?php endif; ?>
		</tr>
		
		<tr>
			<?php
			if (extension_loaded('gd'))
			{
				$ver_info = gd_info();
				preg_match('/\d/', $ver_info['GD Version'], $match);
				$gd_ver = $match[0];
			}
			else
			{
				$gd_ver = '0';
			}
			?>
			<td class='pformleftw'>
				GD Version<br>
				Minimum Version: <strong>v2</strong><br>
				Version Found: <strong>v<?php echo $gd_ver?></strong>
			</td>
			<?php
			if(( (int)str_replace('.', '', (string)$gd_ver) < 2))
			{
				$is_chmod = false;
				?>
				<td class='pformright'>
					<font color="#FF0000" size="4">
						<strong>
							Failed
						</strong>
					</font><br />
					Please recompile php with <a href="http://php.net/manual/en/image.installation.php" target="_blank">GD2 support</a>
				</td>
				<?php
			}
			else
			{
				?>
				<td class='pformright'>
					<font color="#009900" size="4"><strong>Passed</strong></font>
				</td>
				<?php
			}
			?>
		</tr>
		<tr>
			<?php
			if (isset($ver_info["FreeType Support"]))
			{
				$fts = 'Yes';
			}
			else
			{
				$fts = 'No';
			}
			?>
			<td class='pformleftw'>
				FreeType Support Check<br>
				Found: <strong><?php echo $fts?></strong>
			</td>
			<?php
			if($fts == 'No')
			{
				$is_chmod = false;
				?>
				<td class='pformright'>
					<font color="#FF0000" size="4">
						<strong>
							Failed
						</strong>
					</font><br />
					Please recompile php with <a href="http://php.net/manual/en/image.installation.php" target="_blank">FreeType support</a>
				</td>
				<?php
			}
			else
			{
				?>
				<td class='pformright'>
					<font color="#009900" size="4"><strong>Passed</strong></font>
				</td>
				<?php
			}
			?>
		</tr>
		<tr>
			<?php
			if (extension_loaded('simplexml'))
			{
				$fts = 'Yes';
			}
			else
			{
				$fts = 'No';
			}
			?>
			<td class='pformleftw'>
				SimpleXML Support Check<br>
				Found: <strong><?php echo $fts?></strong>
			</td>
			<?php
			if($fts == 'No')
			{
				$is_chmod = false;
				?>
				<td class='pformright'>
					<font color="#FF0000" size="4">
						<strong>
							Failed
						</strong>
					</font><br />
					Please recompile php with <a href="http://php.net/manual/en/book.simplexml.php" target="_blank">SimpleXML support</a>
				</td>
				<?php
			}
			else
			{
				?>
				<td class='pformright'>
					<font color="#009900" size="4"><strong>Passed</strong></font>
				</td>
				<?php
			}
			?>
		</tr>
		<tr>
			<?php
			if (extension_loaded('ftp'))
			{
				$fts = 'Yes';
			}
			else
			{
				$fts = 'No';
			}
			?>
			<td class='pformleftw'>
				FTP Support Check<br>
				Found: <strong><?php echo $fts?></strong>
			</td>
			<?php
			if($fts == 'No')
			{
				$is_chmod = false;
				?>
				<td class='pformright'>
					<font color="#FF0000" size="4">
						<strong>
							Failed
						</strong>
					</font><br />
					Please recompile php with <a href="http://php.net/manual/en/book.ftp.php" target="_blank">FTP support</a>
				</td>
				<?php
			}
			else
			{
				?>
				<td class='pformright'>
					<font color="#009900" size="4"><strong>Passed</strong></font>
				</td>
				<?php
			}
			?>
		</tr>
		</table>
		<div align='center' class='pformstrip'  style='text-align:center; vertical-align:middle'>
				<div style="float:left">
					<span class="cssbutton">
						<a class="buttonRed" href="index.php?c=install&amp;m=step1">
							<img src="../img/icons/back_16.png" border="0" alt="" /> Go Back
						</a>
					</span>
				</div>
				<div style="float:right">
					<span class="cssbutton">
						<a class="buttonGreen" href="index.php?c=install&amp;m=step3">
							<img src="../img/icons/ok_16.png" border="0" alt="" /> Continue
						</a>
					</span>
				</div>
				<?php if(!$is_chmod){ ?>
				<font color="#0000FF">
					<b>
						There were errors during testing. <br>
						Please fix these errors before continuing.<br>
						If you chose to continue you do so at your own risk. <br>
					</b>
				</font>
				<?php }else{ ?>
				<br /><br />
				<?php }?>
			</div>
	</div>
	<div class='fade'>&nbsp;</div>
	<br />
</div>