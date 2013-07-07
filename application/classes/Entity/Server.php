<?php

namespace Entity;

class Server
{
    protected $id;
    protected $name;
    protected $url;
    protected $totalFilesStored;
    protected $freeSpace;
    protected $usedSpace;

    public function __construct($name, $url, $id = null)
    {
        $this->setName($name);

        $this->setUrl($url);

        if($id !== null) {
            $this->setId($id);
        }
    }

    public function setName($serverName)
    {
        $this->name = $serverName;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setUrl()
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    protected function setStoredFileCount($totalFileCount)
    {
        $this->totalFilesStored = $totalFileCount;
    }

    public function getStoredFileCount()
    {
        return $this->totalFilesStored;
    }

    protected function setFreeSpace($freeSpace)
    {
        $this->freeSpace = $freeSpace;
    }

    public function getFreeSpace()
    {
        return $this->freeSpace;
    }

    protected function setUsedSpace($usedSpace)
    {
        $this->usedSpace = $usedSpace;
    }

    public function getUsedSpace()
    {
        return $this->usedSpace;
    }
}