<div style="margin:auto; text-align:center"><h1>Admin User Details</h1></div>
<div class="progressMenu">
	<ul>
		<li class="complete"><a href="index.php?c=install&m=step1"><img src="../img/icons/ok_16.png" border="0" alt="" /> Step 1</a></li>
		<li>&raquo;</li>
		<li class="complete"><a href="index.php?c=install&m=step2"><img src="../img/icons/ok_16.png" border="0" alt="" /> Step 2</a></li>
		<li>&raquo;</li>
		<li class="complete"><a href="index.php?c=install&m=step3"><img src="../img/icons/ok_16.png" border="0" alt="" /> Step 3</a></li>
		<li>&raquo;</li>
		<li class="current"><img src="../img/icons/about_16.png" border="0" alt="" /> Step 4</li>
		<li>&raquo;</li>
		<li> Step 5</li>
	</ul>
</div>
<form id="form1" name="form1" method="post" enctype="multipart/form-data" action="index.php?c=install&m=step5">
<input type="hidden" name="url" value="<?php echo $url?>" />
<input type="hidden" name="enc" value="<?php echo $enc?>" />
	<div class='centerbox'>
		
		<div class='tableborder'>
			<div class='maintitle'>Admin Details</div>
			<div class='pformstrip'>This section requires information to create your administration account. Please enter the data carefully!</div>
			<table width='100%' cellspacing='1'>
				<tr>
				  <td class='pformleftw'><b>Admin Username </b></td>
				  <td class='pformright'><input class="required" minlength="4" name="username" type="text" id="username" size="45" /></td>
				</tr>
				
				<tr>
				  <td class='pformleftw'><b>Password</b></td>
				  <td class='pformright'><input class="required" minlength="5" name="password" type="password" id="password" size="45" /></td>
				</tr>
				
				<tr>
				  <td class='pformleftw'><b>Password Confirmation</b></td>
				  <td class='pformright'><input class="required" minlength="5" equalTo="#password" name="pass_conf" type="password" id="pass_conf" size="45" /></td>
				</tr>
				
				<tr>
				  <td class='pformleftw'><b>Email</b><div class='description'>Optional</div></td>
				  <td class='pformright'><input class="email" name="email" type="text" id="name" size="45" /></td>
				</tr>
				
			</table>
			<div align='center' class='pformstrip'  style='text-align:center; vertical-align:middle'>
				<div style="float:left">
					<span class="cssbutton">
						<a class="buttonRed" href="index.php?c=install&m=step3">
							<img src="../img/icons/back_16.png" border="0" alt="" /> Go Back
						</a>
					</span>
				</div>
				<div style="float:right">
					<span class="cssbutton">
						<a class="buttonGreen" href="javascript:document.form1.submit();" onclick="return $('#form1').validate().form();">
							<img src="../img/icons/ok_16.png" border="0" alt="" /> Continue
						</a>
					</span>
				</div>
				<br /><br />
			</div>
		</div>
		<div class='fade'>&nbsp;</div>
	</div>
</form>   
<script>
$(document).ready(function(){
	$("#form1").validate();
});
</script>