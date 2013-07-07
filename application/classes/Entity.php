<?php

class Entity
{
    protected $id;

    /**
     * Create an entity with an identifier.
     *
     * @param mixed|null $id
     */
    public function __construct( $id = null )
    {
        $this->setId( $id );
    }

    /**
     * Check if there is an identifier.
     *
     * @return bool
     */
    public function hasId()
    {
        return !($this->getId() === null);
    }

    /**
     * Set an identifier.
     *
     * @param mixed $id
     */
    protected function setId( $id )
    {
        $this->id = $id;
    }

    /**
     * Retrieve an identifier.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}