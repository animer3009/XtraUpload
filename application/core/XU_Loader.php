<?php

class XU_Loader extends CI_Loader
{
    protected $_ci_extensions = array();

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Load Extension
     *
     * This function loads the specified extension.
     *
     * @access     public
     * @param      array
     * @return     void
     */
    public function extension($extensions = array())
    {
        if(!is_array($extensions)) {
            $extensions = array($extensions);
        }

        foreach($extensions as $extension) {
            $plugin = strtolower(str_replace(EXT, '', $extension));

            // If the extension is already loaded, continue on.
            if(isset($this->_ci_extensions[$extension])) {
                continue;
            }

            // Attempt to load the extension.
            if(file_exists($extension_path = sprintf(APPPATH.'extend/%s/main'.EXT, $extension))) {
                include $extension_path;
            } else {
                if(file_exists($extension_path = sprintf(BASEPATH.'extend/%s/main'.EXT, $extension))) {
                    include $extension_path;
                } else {
                    show_error(sprintf('Unable to load the requested file: extend/%s/main'.EXT, $extension));
                }
            }

            // Initialize the plugin and log it.
            $this->_ci_extensions[$extension] = new $plugin();

            log_message('debug', sprintf('Extension loaded: %s', $plugin));
        }
    }

    /**
     * Load View
     *
     * Extends on the default view loader.
     *
     * @param $view
     * @param array $vars
     * @param bool $return
     */
    public function view($view, $vars = array(), $return = FALSE)
    {
        if( (substr($view, 0, 7) !== 'default') && !file_exists($file = sprintf(APPPATH.'views/%s'.EXT, $view)) ) {
            list($theme, $path) = explode('/', $view, 2);
            unset($theme);
            $view = sprintf('default/%s', $path);
        }

        return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
    }
}