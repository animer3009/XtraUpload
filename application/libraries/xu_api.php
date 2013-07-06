<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * XtraUpload
 *
 * A turn-key open source Web 2.0 PHP file uploading package requiring PHP v5
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
 * XtraUpload XU_API Library
 *
 * @package		XtraUpload
 * @subpackage	Library
 * @category	Library
 * @author		Matthew Glinski
 * @link		http://xtrafile.com/docs/api
 */

// ------------------------------------------------------------------------

class Xu_api
{
	public $menus;
	private $CI;
    private $apiDirectory;
	
	public function __construct($apiDirectory = null)
	{
        if($apiDirectory !== null) {
            $this->setApiDirectory($apiDirectory);
        }

        if($this->apiDirectoryExists()) {
            show_error('COMPLETE FAIL, REUPLOAD FILES');
        }

        $this->CI =& get_instance();

        $apiFiles = $this->determineApiFiles($this->getApiDirectory());

        foreach($apiFiles as $class => $file)
        {
            $this->initializeApi($class, $file);
        }

        log_message('debug', "XtraUpload API Class Initialized");
	}

    /**
     * Determine the API files that can be loaded.
     *
     * @param $apiDirectory
     * @return array
     */
    private function determineApiFiles($apiDirectory)
    {
        $fileList = array();

        if ($dh = opendir($apiDirectory))
        {
            while (($file = readdir($dh)) !== false)
            {
                if (!is_dir($this->getApiDirectory() . $file) and substr($file, -8) == '_api.php')
                {
                    $fileList[ucfirst(str_replace('.php', '', $file))] = $file;
                }
            }

            closedir($dh);
        }

        return $fileList;
    }

    /**
     * Determine if the API directory exists.
     *
     * @return bool
     */
    private function apiDirectoryExists()
    {
        return !is_dir($this->getApiDirectory());
    }

    /**
     * Set the API directory to a path.
     *
     * @param $apiDirectory
     */
    private function setApiDirectory($apiDirectory)
    {
        $this->apiDirectory = $apiDirectory;
    }

    /**
     * Return the API directory defined.
     *
     * @return string
     */
    public function getApiDirectory()
    {
        if($this->apiDirectory === null) {
            return APPPATH."libraries/api/";
        }

        return $this->apiDirectory;
    }

    /**
     * Initialize an API
     *
     * @param $class
     * @param $file
     */
    private function initializeApi($class, $file)
    {
        $name = str_replace(array('_api', 'xu_', 'Xu_'), '', $class);

        include_once($this->getApiDirectory() . $file);

        $this->$name = new $class();
    }
}