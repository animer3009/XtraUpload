<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class XU_FTP extends CI_FTP {

    var $error_msg  = '';
    var $error      = FALSE;

    // --------------------------------------------------------------------

    /**
     * FTP Connect
     *
     * @access	public
     * @param	array	 the connection values
     * @return	bool
     */
    function connect($config = array())
    {
        if (count($config) > 0)
        {
            $this->initialize($config);
        }

        if (FALSE === ($this->conn_id = @ftp_connect($this->hostname, $this->port)))
        {
            if ($this->debug == TRUE)
            {
                $this->_error('ftp_unable_to_connect');
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = 'ftp_unable_to_connect';
            }
            return FALSE;
        }

        if ( ! $this->_login())
        {
            if ($this->debug == TRUE)
            {
                $this->_error('ftp_unable_to_login');
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = 'ftp_unable_to_login';
            }
            return FALSE;
        }

        // Set passive mode if needed
        if ($this->passive == TRUE)
        {
            ftp_pasv($this->conn_id, TRUE);
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * FTP Login
     *
     * @access	private
     * @return	bool
     */
    function _login()
    {
        return @ftp_login($this->conn_id, $this->username, $this->password);
    }

    // --------------------------------------------------------------------

    /**
     * Validates the connection ID
     *
     * @access	private
     * @return	bool
     */
    function _is_conn()
    {
        if ( ! is_resource($this->conn_id))
        {
            if ($this->debug == TRUE)
            {
                $this->_error('ftp_no_connection');
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = 'ftp_no_connection';
            }
            return FALSE;
        }
        return TRUE;
    }

    // --------------------------------------------------------------------


    /**
     * Change directory
     *
     * The second parameter lets us momentarily turn off debugging so that
     * this function can be used to test for the existence of a folder
     * without throwing an error.  There's no FTP equivalent to is_dir()
     * so we do it by trying to change to a particular directory.
     * Internally, this parameter is only used by the "mirror" function below.
     *
     * @access	public
     * @param	string
     * @param	bool
     * @return	bool
     */
    function changedir($path = '', $supress_debug = FALSE)
    {
        if ($path == '' OR ! $this->_is_conn())
        {
            return FALSE;
        }

        $result = @ftp_chdir($this->conn_id, $path);

        if ($result === FALSE)
        {
            if ($this->debug == TRUE AND $supress_debug == FALSE)
            {
                $this->_error('ftp_unable_to_changedir');
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = 'ftp_unable_to_changedir';
            }
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Create a directory
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function mkdir($path = '', $permissions = NULL)
    {
        if ($path == '' OR ! $this->_is_conn())
        {
            return FALSE;
        }

        $result = @ftp_mkdir($this->conn_id, $path);

        if ($result === FALSE)
        {
            if ($this->debug == TRUE)
            {
                $this->_error('ftp_unable_to_mkdir');
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = 'ftp_unable_to_mkdir';
            }
            return FALSE;
        }

        // Set file permissions if needed
        if ( ! is_null($permissions))
        {
            $this->chmod($path, (int)$permissions);
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Upload a file to the server
     *
     * @access	public
     * @param	string
     * @param	string
     * @param	string
     * @return	bool
     */
    function upload($locpath, $rempath, $mode = 'auto', $permissions = NULL)
    {
        if ( ! $this->_is_conn())
        {
            return FALSE;
        }

        if ( ! file_exists($locpath))
        {
            $this->_error('ftp_no_source_file');
            return FALSE;
        }

        // Set the mode if not specified
        if ($mode == 'auto')
        {
            // Get the file extension so we can set the upload type
            $ext = $this->_getext($locpath);
            $mode = $this->_settype($ext);
        }

        $mode = ($mode == 'ascii') ? FTP_ASCII : FTP_BINARY;

        $result = @ftp_put($this->conn_id, $rempath, $locpath, $mode);

        if ($result === FALSE)
        {
            if ($this->debug == TRUE)
            {
                $this->_error('ftp_unable_to_upload');
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = 'ftp_unable_to_upload';
            }
            return FALSE;
        }

        // Set file permissions if needed
        if ( ! is_null($permissions))
        {
            $this->chmod($rempath, (int)$permissions);
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Download a file from a remote server to the local server
     *
     * @access	public
     * @param	string
     * @param	string
     * @param	string
     * @return	bool
     */
    function download($rempath, $locpath, $mode = 'auto')
    {
        if ( ! $this->_is_conn())
        {
            return FALSE;
        }

        // Set the mode if not specified
        if ($mode == 'auto')
        {
            // Get the file extension so we can set the upload type
            $ext = $this->_getext($rempath);
            $mode = $this->_settype($ext);
        }

        $mode = ($mode == 'ascii') ? FTP_ASCII : FTP_BINARY;

        $result = @ftp_get($this->conn_id, $locpath, $rempath, $mode);

        if ($result === FALSE)
        {
            if ($this->debug == TRUE)
            {
                $this->_error('ftp_unable_to_download');
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = 'ftp_unable_to_download';
            }
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Rename (or move) a file
     *
     * @access	public
     * @param	string
     * @param	string
     * @param	bool
     * @return	bool
     */
    function rename($old_file, $new_file, $move = FALSE)
    {
        if ( ! $this->_is_conn())
        {
            return FALSE;
        }

        $result = @ftp_rename($this->conn_id, $old_file, $new_file);

        if ($result === FALSE)
        {
            if ($this->debug == TRUE)
            {
                $msg = ($move == FALSE) ? 'ftp_unable_to_rename' : 'ftp_unable_to_move';

                $this->_error($msg);
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = ($move == FALSE) ? 'ftp_unable_to_rename' : 'ftp_unable_to_move';
            }
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Rename (or move) a file
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function delete_file($filepath)
    {
        if ( ! $this->_is_conn())
        {
            return FALSE;
        }

        $result = @ftp_delete($this->conn_id, $filepath);

        if ($result === FALSE)
        {
            if ($this->debug == TRUE)
            {
                $this->_error('ftp_unable_to_delete');
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = 'ftp_unable_to_delete';
            }
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Delete a folder and recursively delete everything (including sub-folders)
     * containted within it.
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function delete_dir($filepath)
    {
        if ( ! $this->_is_conn())
        {
            return FALSE;
        }

        // Add a trailing slash to the file path if needed
        $filepath = preg_replace("/(.+?)\/*$/", "\\1/",  $filepath);

        $list = $this->list_files($filepath);

        // TODO: Not sure why it removed count($list) > 0.
        if ($list !== FALSE)
        {
            foreach ($list as $item)
            {
                // If we can't delete the item it's probaly a folder so
                // we'll recursively call delete_dir()
                if ( ! @ftp_delete($this->conn_id, $item))
                {
                    $this->delete_dir($item);
                }
            }
        }

        $result = @ftp_rmdir($this->conn_id, $filepath);

        if ($result === FALSE)
        {
            if ($this->debug == TRUE)
            {
                $this->_error('ftp_unable_to_delete');
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = 'ftp_unable_to_delete';
            }
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Set file permissions
     *
     * @access	public
     * @param	string	the file path
     * @param	string	the permissions
     * @return	bool
     */
    function chmod($path, $perm)
    {
        if ( ! $this->_is_conn())
        {
            return FALSE;
        }

        // Permissions can only be set when running PHP 5
        if ( ! function_exists('ftp_chmod'))
        {
            if ($this->debug == TRUE)
            {
                $this->_error('ftp_unable_to_chmod');
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = 'ftp_unable_to_chmod';
            }
            return FALSE;
        }

        $result = @ftp_chmod($this->conn_id, $perm, $path);

        if ($result === FALSE)
        {
            if ($this->debug == TRUE)
            {
                $this->_error('ftp_unable_to_chmod');
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = 'ftp_unable_to_chmod';
            }
            return FALSE;
        }

        return TRUE;
    }

    // ------------------------------------------------------------------------

    /**
     * Return error message
     *
     * @access      private
     * @param       string
     * @return      bool
     *
     */
    function get_error()
    {
        $CI =& get_instance();
        $CI->lang->load('ftp');
        return $CI->lang->line($this->error_msg);
    }

    // ------------------------------------------------------------------------

    /**
     * Filesize of Remote File
     *
     * @access      public
     * @param       string
     * @return      mixed
     *
     */

    function remote_filesize($path)
    {
        if(!$this->_is_conn()) {
            return FALSE;
        }

        $contents = ftp_raw($this->conn_id, sprintf("SIZE %s", $path));
        $result = substr($contents[0], strpos($contents[0], " "));

        if(subistr($result, 'check'))
        {
            return FALSE;
        }

        return $result;
    }


    // ------------------------------------------------------------------------

    /**
     * Download a file
     *
     */

    function download_xu2($remote_file, $fid, $max_size)
    {
        if(!$this->_is_conn())
        {
            return FALSE;
        }

        $result = TRUE;

        // TODO: Make this use cache.
        $tmpfname = tempnam('./temp', 'RFT-');
        $l_fp = fopen($tmpfname, "wb");

        $i = 0;
        $CI =& get_instance();

        $ret = ftp_nb_fget($this->conn_id, $l_fp, $remote_file, FTP_BINARY);

        while($ret == FTP_MOREDATA)
        {
            if($i % 10 == 0) {
                $fstat = fstat($l_fp);
                $p = $fstat[7];
                $CI->db->where('fid', $fid);
                $CI->db->update('progress', array('progress' => $p, 'curr_time' => time()));
            }

            // Continue downloading...
            $ret = ftp_nb_continue($this->conn_id);
            $i++;
        }

        if($ret != FTP_FINISHED) {
            log_message('error', 'FTP TRANSFER FAILED');
            $result = FALSE;
        }

        if ($result === FALSE)
        {
            if ($this->debug == TRUE)
            {
                $msg = 'ftp_unable_to_download';
                $this->_error($msg);
            }
            else
            {
                $this->error = TRUE;
                $this->error_msg = 'ftp_unable_to_download';
            }

            return FALSE;
        }

        return $tmpfname;
    }

    // ------------------------------------------------------------------------

}