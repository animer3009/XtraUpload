		<!-- main ends -->	
		</div>
		
		<!-- sidebar starts -->
		<div id="sidebar">
			<?php
			if($this->uri->segment(1) === 'admin')
			{
				$this->load->view($skin.'/admin/menu');
			}
			else
			{
				$this->load->view($skin.'/menu');
			}
			?>
            <!-- sidebar ends -->
		</div>
		
	<!-- content-wrap ends-->	
	</div>
	
	<!-- footer starts -->		
	<div id="footer">	
		<p>
			<?=$this->lang->line('global_copyright')?> 2006 - <?=date('Y')?> <a href="http://xtrafile.com"><strong><?=$this->lang->line('global_xtrafile')?></strong></a>
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<?=$this->lang->line('global_design')?> <a href="http://styleshout.com">styleshout</a>
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<?=$this->lang->line('global_valid')?> <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> |
		   	   <a href="http://validator.w3.org/check/referer">XHTML</a>
			</p> 	
	
	<!-- footer ends-->
	</div>

<!-- wrap ends here -->
</div>
<script type="text/javascript">
$(document).ready(function()
{
	$('input, select').bind('focus', function()
	{
		$(this).animate({backgroundColor:"#FFFFCC"}, "fast");
	});
	$('input, select').bind('blur', function()
	{
		$(this).animate({backgroundColor:"#FFFFFF"}, "fast");
	});
	$("a[@rel='external']").attr('target', '_blank');
	if($.browser.opera)
	{
		$(".pasteButton").remove();
	}
});
</script>
<?php$this->load->view('_protected/global_footer');?>
</body>
</html>