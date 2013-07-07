<?php

namespace ValueObject;

class FileExtension
{
    protected $extension;

    public function __construct($extensionCode)
    {
        $this->extension = $extensionCode;
    }

    public function getExtension()
    {
        return $this->extension;
    }
}