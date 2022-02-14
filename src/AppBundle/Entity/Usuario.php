<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GuardBundle\Entity\Usuario as BaseUser;

/**
 * Usuario
 *
 * @ORM\Table(name="neosys.usuarios")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario extends BaseUser
{
    public function __construct() {
        parent::__construct();
    }
}

