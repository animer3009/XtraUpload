<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class XU_Config extends CI_Config {

    function site_url($uri = '', $base_url = false)
    {
        $base_url = $base_url !== false && is_string($base_url) ? $base_url : $this->slash_item('base_url');

        if ($uri == '')
        {
            return $base_url.$this->item('index_page');
        }

        if ($this->item('enable_query_strings') == FALSE)
        {
            $suffix = ($this->item('url_suffix') == FALSE) ? '' : $this->item('url_suffix');
            return $base_url.$this->slash_item('index_page').$this->_uri_string($uri).$suffix;
        }
        else
        {
            return $base_url.$this->item('index_page').'?'.$this->_uri_string($uri);
        }
    }

}