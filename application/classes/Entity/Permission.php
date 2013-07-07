<?php

namespace Entity;

use Entity;

class Permission extends Entity
{
    protected $name;
    protected $description;
    protected $value;

    /**
     * @param string $name
     * @param mixed $value
     * @param string|null $description
     * @param mixed|null $id
     */
    public function __construct($name, $value, $description = null, $id = null)
    {
        parent::__construct($id);

        $this->setName($name);
        $this->setValue($value);
        $this->setDescription($description);
    }

    /**
     * Set the permission name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Retrieve the permission name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the permission value.
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Retrieve the permission value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the permission description.
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = (string) $description;
    }

    /**
     * Retrieve the permission description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}