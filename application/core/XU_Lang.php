<?php

class XU_Lang extends CI_Lang
{
    /**
     * Fetch a single line of text from the language array
     *
     * @access	public
     * @param	string	$line	the language line
     * @param*  string  overload  sprintf-like syntax
     * @return	string
     */
    function line($line = '')
    {
        $value = ($line == '' OR ! isset($this->language[$line])) ? FALSE : $this->language[$line];

        // Because killer robots like unicorns!
        if ($value === FALSE)
        {
            log_message('error', 'Could not find the language line "'.$line.'"');
        }
        else
        {
            if(func_num_args() > 1)
            {
                $arg_list = func_get_args();
                unset($arg_list[0]);
                return vsprintf($this->language[$line], $arg_list);
            }
        }

        return $value;
    }
}