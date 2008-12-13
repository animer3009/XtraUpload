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
 * XtraUpload Extend Page Controller
 *
 * @package		XtraUpload
 * @subpackage	Controllers - Admin
 * @category	Controllers
 * @author		Matthew Glinski
 * @link		http://xtrafile.com/docs/pages/admin/extend
 */

// ------------------------------------------------------------------------

class Extend extends Controller 
{
	private $installed='';
	private $not_installed='';
	
	// ------------------------------------------------------------------------
	
	public function Extend()
	{
		parent::Controller();		
		$this->load->model('admin_access');
		$this->load->helper('string');
		$this->load->helper('text');
	}
	
	// ------------------------------------------------------------------------s
	
	public function index()
	{
		redirect('admin/extend/view');
	}
	
	// ------------------------------------------------------------------------
	
	public function view()
	{
		$this->_getInstalledPlugins();
		$this->_getNotInstalledPlugins();
		
		$data['installed']=array();
		$data['not_installed']=array();
		
		foreach($this->installed as $name)
		{
			$data['installed'][$name] = simplexml_load_file(APPPATH."models/extend/info/".$name.'.xml');
		}
		
		foreach($this->not_installed as $name)
		{
			$data['not_installed'][$name] = simplexml_load_file(APPPATH."models/extend/info/".$name.'.xml');
		}
		
		$data['flashMessage'] = '';
		if($this->session->flashdata('msg'))
		{
			$data['flashMessage'] = '<span class="info"><b>'.$this->session->flashdata('msg').'</b></span>';
		}
		
		$this->load->view($this->startup->skin.'/header', array('headerTitle' => 'Plugin Manager'));
		$this->load->view($this->startup->skin.'/admin/extend/view', $data);
		$this->load->view($this->startup->skin.'/footer');
	}
	
	// ------------------------------------------------------------------------
	
	public function install($name)
	{
		$name = str_replace(array('../', '..'), '', $name);
		$num_rows = $this->db->get_where('extend', array('file_name' => $name))->num_rows();
		if(file_exists(APPPATH."models/extend/".$name.'.php') and file_exists(APPPATH."models/extend/info/".$name.'.xml') and $num_rows == 0)
		{
			$xml = simplexml_load_file(APPPATH."models/extend/info/".$name.'.xml');
			$data = array(
				'data' => serialize($xml),
				'file_name' => $name,
				'date' => time(),
				'active' => '1',
				'uid' => $this->session->userdata('id'),
			);
			
			$this->db->insert('extend', $data);
			
			$this->load->model('extend/'.$name);			
			$this->$name->install();
			
			$this->session->set_flashdata('msg', 'Plugin "'.ucwords(str_replace('_', ' ', $name)).'" Installed');
		}
		$this->_updateCache();
		redirect('admin/extend/view');
	}
	
	// ------------------------------------------------------------------------
	
	public function remove($name)
	{
		$this->load->model('/extend/'.$name);
		$this->$name->uninstall();
		
		$this->db->delete('extend', array('file_name' => $name));
		$this->session->set_flashdata('msg', 'Plugin "'.ucwords(str_replace('_', ' ', $name)).'" Uninstalled');
		$this->_updateCache();
		redirect('admin/extend/view');
	}
	
	// ------------------------------------------------------------------------
	
	public function turn_on($name)
	{
		$this->db->where('file_name', $name)->update('extend', array('active' => 1));
		$this->session->set_flashdata('msg', 'Plugin "'.ucwords(str_replace('_', ' ', $name)).'" Activated');
		$this->_updateCache();
		redirect('admin/extend/view');
	}
	
	// ------------------------------------------------------------------------
	
	public function turn_off($name)
	{
		$this->db->where('file_name', $name)->update('extend', array('active' => 0));
		$this->session->set_flashdata('msg', 'Plugin "'.ucwords(str_replace('_', ' ', $name)).'" Deactivated');
		$this->_updateCache();
		redirect('admin/extend/view');
	}
	
	// ------------------------------------------------------------------------
	
	private function _updateCache()
	{
		$extend_file_name = md5($this->config->config['encryption_key'].'extend');
		
		$data = array();
		$db1 = $this->db->get_where('extend', array('active' => 1));
		foreach($db1->result() as $plugin)
		{
			$data[] = $plugin->file_name;
		}
		
		if(empty($data))
		{
			@unlink(CACHEPATH . $extend_file_name);
		}
		else
		{
			$final = base64_encode(serialize($data));
			file_put_contents(CACHEPATH . $extend_file_name, $final);
		}
		
		$this->load->library('remote_server_xml_rpc');
		$this->remote_server_xml_rpc->update_cache();
	}
	
	// ------------------------------------------------------------------------
	
	private function _getInstalledPlugins()
	{
		if(is_array($this->installed))
		{
			return $this->installed;
		}
		
		$this->installed = array();
		$db1 = $this->db->get('extend');
		foreach($db1->result() as $plugin)
		{
			$this->installed[] = $plugin->file_name;
		}
		return $this->installed;
	}
	
	// ------------------------------------------------------------------------
	
	private function _getNotInstalledPlugins()
	{
		if(is_array($this->not_installed))
		{
			return $this->not_installed;
		}
		
		$this->not_installed = array();
		$dir = APPPATH."models/extend/";

		// Open a known directory, and proceed to read its contents
		if (is_dir($dir)) 
		{
			if ($dh = opendir($dir)) 
			{
				while (($file = readdir($dh)) !== false) 
				{
					$app = explode('.php', $file);
					$app = $app[0];
					if(!is_dir($dir . $file) and substr($file, -4) == '.php' and !in_array($app, $this->installed) )
					{
						$this->not_installed[] = $app;
					}
				}
				closedir($dh);
			}
		}
		return $this->not_installed;
	}
}