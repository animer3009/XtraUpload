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
	<div id="footer-wrap">
		<div id="footer-content">
	
			<div id="footer-columns">	
				<div class="col3">
					<?php if($this->startup->site_config['show_recent_uploads']){?>
						<h3><?=$this->lang->line('global_recently_uploaded_files')?></h3>
						<ul class="col-list">
						<?php 
						$query = $this->files_db->getRecentFiles(5);
						foreach($query->result() as $file)
						{
							$links = $this->files_db->getLinks('', $file);
							?>	<li>
									<a href="<?=$links['down'];?>">
										<img src="<?=base_url().'img/files/'.$this->functions->getFileTypeIcon($file->type);?>" class="nb" alt="" />
										<?=$this->functions->elipsis($file->o_filename, 10);?>
									</a>
								</li>
							<?php
						}
						?>
						</ul>
					<?php }?>
				</div>
		
				<div class="col3-center">
					<h3 class="no-line">&nbsp;</h3>
				</div>
		
				<div class="col3">
					<h3><?=$this->lang->line('global_footer_about')?></h3>
				
					<p>
						<a href="http://xtrafile.com"><img src="<?=$base_url?>images/thumb.gif" width="50" height="50" alt="icon" class="float-left" /></a>
						<a href="http://xtrafile.com/products/xtraupload-v2/"><?=$this->lang->line('global_xtraupload_v2')?></a>
						<?=$this->lang->line('global_footer_about_text1')?> <a href="http://xtrafile.com/products/xtraupload-v2/"><?=$this->lang->line('global_xtraupload_v2')?></a> <?=$this->lang->line('global_footer_about_text2')?> <a href="http://www.codeigniter.com"><?=$this->lang->line('global_codeigniter')?></a> <?=$this->lang->line('global_footer_about_text3')?>
					</p>
				</div>
			<!-- footer-columns ends -->
			</div>	
					
			<div id="footer-bottom">
			<p>
						<?=$this->lang->line('global_copyright')?> 2006 - <?=date('Y')?>
						<a href="http://xtrafile.com"><strong><?=$this->lang->line('global_xtrafile')?></strong></a>
						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						 
						<?=$this->lang->line('global_design')?> <a href="http://styleshout.com">styleshout</a>
						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
						<?=$this->lang->line('global_valid')?> <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> |
					   <a href="http://validator.w3.org/check/referer">XHTML</a>
					</p> 				
			</div>	
			
		<!-- footer ends-->
		</div>
	</div>

<!-- wrap ends here -->
</div>
<script type="text/javascript">
$(document).ready(function()
{
	$('input, select').css('background-color', '#FFFFFF');
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
<?php $this->load->view('_protected/global_footer');?>
</body>
</html>