<h2 style="vertical-align:middle">
	<img src="<?=$base_url.'img/icons/user_32.png'?>" class="nb" alt="" /> <?=$this->lang->line('user_register_pay_header')?>
</h2>

<?=$form;?>
<script type="text/javascript">
function submitPayForm()
{
	$('#gateway_form_submit').get(0).submit();	
}

$(document).ready(function()
{
	setTimeout('submitPayForm()', 2000);
});
</script>