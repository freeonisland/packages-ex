<?php

namespace Ldap\Entity;

class User
{
    private $id;
    public $name, $surname, $phone;

    /**
     * Accessors, mutators functions...
     */
    function setId($id) { $this->id = $id; }
    function getId() { return $this->id; }
}