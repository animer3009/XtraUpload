<?php
if(!isset($headerTitle))
{
    $headerTitle = '';
}
else
{
    $headerTitle .= ' '.$this->startup->site_config['title_separator'].' ';
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xml:lang="en" >
<head>
    <title><?=$headerTitle.$this->startup->site_config['sitename']?></title>

    <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    <meta name="author" content="Matthew Glinski - xtrafile.com" />
    <meta name="description" content="Site Description Here" />
    <meta name="keywords" content="keywords, here" />
    <meta name="robots" content="index, follow, noarchive" />
    <meta name="googlebot" content="noarchive" />
    <link rel="shortcut icon" href="<?=$base_url?>favicon.ico" />

    <link rel="stylesheet" type="text/css" media="screen" href="<?=$base_url?>css/main.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?=$base_url?>css/default/default.css" />
    <!--[if lte IE 6]>
    <link rel="stylesheet" type="text/css" media="screen" href="<?=$base_url?>css/ie6.css" />
    <![endif]-->

    <script type="text/javascript">
        function ___imageClose(){return '<?=site_url('images/lightbox-btn-close.gif')?>';}
        function ___imageLoading(){return '<?=site_url('images/loading.gif')?>';}
        function ___baseUrl(){return '<?=$base_url?>';}
        function ___siteUrl(){return '<?=$base_url.$this->config->config['index_page']?>/';}
    </script>
    <script src="<?=$base_url?>js/main.php" type="text/javascript"></script>
    <?php
    if(isset($include_flash_upload_js) and $include_flash_upload_js == true)
    {
        ?>
        <script src="<?=$base_url?>js/upload.js" type="text/javascript"></script>
    <?php
    }
    if(isset($include_url_upload_js) and $include_url_upload_js == true)
    {
        ?>
        <script src="<?=$base_url?>js/url.js" type="text/javascript"></script>
    <?php
    }
    ?>
</head>
<body dir="<?=$this->lang->line('global_language_direction')?>">
<!-- wrap starts here -->
<div id="wrap">

    <!--header -->
    <div id="header">
        <div id="nav">
            <ul>
                <?=$this->xu_api->menus->getMainMenu();?>
            </ul>
        </div>

        <form id="quick-search" action="index.html" method="get" >
            <h1><?=$this->startup->site_config['sitename']?></h1>
        </form>

        <!--header ends-->
    </div>

    <!-- content-wrap starts -->
    <div id="content-wrap">

        <div id="main">

            <?= $yield ?>

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

    <!-- footer starts here -->
    <div id="footer-wrap"><div id="footer-content">

            <div class="col float-left space-sep">
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

            <div class="col float-left">

            </div>

            <div class="col2 float-right">

                <h3><?=$this->lang->line('global_footer_about')?></h3>

                <p>
                    <a href="http://xtrafile.com"><img src="<?=$base_url?>images/thumb.gif" width="50" height="50" alt="icon" class="float-left" /></a>
                    <a href="http://xtrafile.com/products/xtraupload-v2/"><?=$this->lang->line('global_xtraupload_v2')?></a>
                    <?=$this->lang->line('global_footer_about_text1')?> <a href="http://xtrafile.com/products/xtraupload-v2/"><?=$this->lang->line('global_xtraupload_v2')?></a> <?=$this->lang->line('global_footer_about_text2')?> <a href="http://www.codeigniter.com"><?=$this->lang->line('global_codeigniter')?></a> <?=$this->lang->line('global_footer_about_text3')?></p>

                <p>
                    <?=$this->lang->line('global_copyright')?> 2006 - <?=date('Y')?> <a href="http://xtrafile.com"><strong><?=$this->lang->line('global_xtrafile')?></strong></a><br />


                    <?=$this->lang->line('global_design')?> <a href="http://styleshout.com">styleshout</a><br />

                    <a href="<?=site_url('legal/tos')?>">Terms Of Service</a> |
                    <a href="<?=site_url('legal/privacy')?>">Privacy Policy</a><br />

                    <?=$this->lang->line('global_valid')?> <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> |
                    <a href="http://validator.w3.org/check/referer">XHTML</a> -
                    <a href="javascript:;" onclick="$('#debug').toggle('fast')"><?=$this->lang->line('global_debug')?></a>
			   <span style="color:#FF0000; display:none" id="debug">
			       <?=$this->lang->line('global_execution')?> <?=$this->benchmark->elapsed_time()?><br />
                   <?=$this->lang->line('global_memory')?> <?=round(memory_get_usage() / 1024)?>KB
			   </span>
                </p>
            </div>

        </div></div>
    <div class="clearer"></div>
    <!-- footer ends here -->

    <!-- wrap ends here -->
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('input, textarea').bind('focus', function()
        {
            $(this).animate({backgroundColor:"#101010"}, "fast");
        });
        $('input, textarea').bind('blur', function()
        {
            $(this).animate({backgroundColor:"#070707"}, "fast");
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