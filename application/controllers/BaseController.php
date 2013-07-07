<?php

class BaseController extends CI_Controller
{
    protected $layout;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setLayout($layout)
    {
        $this->layout = $layout;
    }

    protected function getLayout()
    {
        return $this->startup->skin.DIRECTORY_SEPARATOR.$this->layout;
    }

    protected function render($path, $data = array(), $asString = false)
    {
        $yieldedContent = $this->load->view($this->startup->skin.DIRECTORY_SEPARATOR.$path, $data, true);

        $layoutData = array();

        if(array_key_exists('layout', $data))
        {
            $layoutData = $data['layout'];
        }

        $layoutData['yield'] = $yieldedContent;

        if ($asString) {
            return $this->load->view($this->getLayout(), $layoutData, true);
        }

        $this->load->view($this->getLayout(), $layoutData);
    }
}