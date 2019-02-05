<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use ApiPlatform\Core\Annotation\ApiResource;


/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateur")
 * @ApiResource()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */

    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}