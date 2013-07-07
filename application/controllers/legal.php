<?php
/**
 * XtraUpload
 *
 * A turn-key open source web 2.0 PHP file uploading package requiring PHP v5
 *
 * @package		XtraUpload
 * @author		Matthew Glinski
 * @copyright	Copyright (c) 2006, XtraFile.com
 * @license		http://xtrafile.com/docs/license
 * @link		http://xtrafile.com
 * @since		Version 2.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * XtraUpload Cron Controller
 *
 * @package		XtraUpload
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Matthew Glinski
 * @link		http://xtrafile.com/docs/cron
 */

// ------------------------------------------------------------------------

class Legal extends BaseController
{
	protected $layout = 'layout';

	public function __construct()
	{
		parent::__construct();
		
		$this->lang->load('legal');
	}
	
	public function index()
	{
		show_404();
	}
	
	public function tos()
	{
        $this->render('legal/tos', array(
            'layout' => array(
                'headerTitle' => $this->lang->line('legal_tos_headertitle'),
            ),
            'site_name' => $this->startup->site_config['sitename']
        ));
	}
	
	public function privacy()
	{
        $this->render('legal/privacy', array(
            'layout' => array(
                'headerTitle' => $this->lang->line('legal_privacy_headertitle'),
            )
        ));
	}
}