<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
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
 * XtraUpload Servers DB Model
 *
 * @package		XtraUpload
 * @subpackage	Model
 * @category	Model
 * @author		Matthew Glinski
 * @link		http://xtrafile.com/docs/pages/files
 */

// ------------------------------------------------------------------------

class Server_db extends Model 
{
    public function Server_db()
    {
		// Call the Model constructor
        parent::Model();
    }
	
	// ------------------------------------------------------------------------

	public function getServers()
	{
		return $this->db->get('servers');
	}
	
	// ------------------------------------------------------------------------

	public function getServer($id)
	{
		return $this->db->get('servers', array('id' => $id))->row();
	}
		
	// ------------------------------------------------------------------------
	
	public function getServerForDownload($file)
	{
		if(!$file->mirror)
		{
			if(substr($file->server, -1) != '/')
			{
				$file->server .= '/';
			}
			return $file->server;
		}
		else
		{
			$server = $file->server;
			$arr = unserialize($servers);
			$serv = $arr[rand(0, (count($arr)-1))];
			if(substr($serv, -1) != '/')
			{
				$serv .= '/';
			}
			return $serv;
		}
	}
	
	// ------------------------------------------------------------------------

	public function getRandomServer()
	{
		$this->db->order_by('id', 'RANDOM');
		$get = $this->db->get_where('servers', array('status' => '1'), 1, 0);
		
		if($get->num_rows() != 1)
		{
			$this->db->order_by('id', 'RANDOM');
			$get = $this->db->get('servers', 1, 0);
			return $get->row();
		}
		else
		{
			return $get->row();
		}
	}
	
	// ------------------------------------------------------------------------

	public function getServerById($id)
	{
		return $this->db->get_where('servers', array('id' => $id), 1, 0)->row();
	}
	
	// ------------------------------------------------------------------------
	
	public function editServer($id, $data)
	{
		$this->db->where('id', $id)->update('servers', $data);
	}
	
	// ------------------------------------------------------------------------
	
	public function addServer($data)
	{
		return $this->db->insert('servers', $data)->insert_id();
	}
	
	// ------------------------------------------------------------------------
	
	public function deleteServer($id)
	{
		$this->db->delete('servers', array('id' => $id));
	}
}