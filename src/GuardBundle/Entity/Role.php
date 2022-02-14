<?php

namespace GuardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Role
 *
 * @ORM\Table(name="neosys.g_role")
 * @ORM\Entity(repositoryClass="GuardBundle\Repository\RoleRepository")
 */
class Role implements RoleInterface
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;


    /**
    *@ORM\ManyToMany(targetEntity="Usuario", mappedBy="roles")
    */
    private $usuarios;

    
    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
    }
    
    //Solicita el implement
    public function getRole() {
        return $this->role;
    }
    
    /**
     * Set rol
     *
     * @param string $rol
     *
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

      /**
     * Add users
     *
     * 
     * @return Role
     */
    public function addUsuario(Usuario $usuario)
    {
        if ($this->usuarios->contains($usuario)) {
            return;
        }
        $this->usuarios->add($usuario);
    
        return $this;
    }

    /**
     * Remove users
     *
     * 
     */
    public function removeUsuario(Usuario $usuario)
    {
        if (!$this->usuarios->contains($usuario)) {
            return;
        }
        $this->usuarios->removeElement($usuario);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

}

