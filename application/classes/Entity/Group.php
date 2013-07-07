<?php

namespace Entity;

use Aggregate\Permission as PermissionAggregate;
use Entity;

class Group extends Entity
{
    protected $name;
    protected $isActive;
    protected $description;

    protected $subscription;

    protected $permissions;

    protected $speedLimit;
    protected $uploadSizeLimit;
    protected $waitTime;
    protected $allowedFileTypes;
    protected $deniedFileTypes;
    protected $hasDownloadCaptcha;
    protected $hasInstantDownload;
    protected $storageLimit;
    protected $canSearch;
    protected $canFlashUpload;
    protected $canUrlUpload;
    protected $fileExpirationTime;
    protected $isAdmin;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setActiveFlag($flag)
    {
        if(!is_bool($flag)) {
            throw new \InvalidArgumentException("First argument must be a boolean.");
        }

        $this->isActive = $flag;
    }

    public function isActive()
    {
        return $this->isActive;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setSubscription(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function getSubscription()
    {
        return $this->subscription;
    }

    public function setPermissions(PermissionAggregate $permissions)
    {
        $this->permissions = $permissions;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function getPermission($key)
    {
        return $this->permissions->get($key);
    }
}