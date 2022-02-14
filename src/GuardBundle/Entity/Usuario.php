<?php

namespace GuardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/** 
 * @ORM\MappedSuperclass 
 * @ORM\Table(name="neosys.usuarios")
 */

abstract class Usuario implements UserInterface
{
    /**
     * @var string
     * @ORM\Id
     *
     * @ORM\Column(name="usuario", type="string", length=20)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password_mail", type="string", length=100)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_mail", type="string", length=100)
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=50)
     */
    private $apellido;
    
    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="usuarios")
     * @ORM\JoinTable(name="neosys.g_usuarios_roles",
     *      joinColumns={@ORM\JoinColumn(name="username_id", referencedColumnName="usuario")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="role")}
     * )
     *
     */
    private $roles;
    
    /**
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;
    
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getUsername();
    }
    /**
     * Set username
     *
     * @param string $username
     *
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getApellido()
    {
        return $this->apellido;
    }
    
    public function getNombreCompleto()
    {
        return $this->apellido . ', ' . $this->name;
    }        
    
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
    
//     public function getRoles()
//    {
//        return array('ROLE_USER');
//    }

    public function eraseCredentials()
    {
        return null;
    }

        
    public function getRoles() {
        
        return $this->roles->toArray();
        //return array('ROLE_USER');
    }
    

    public function addRole(Role $role)
    {
        if ($this->roles->contains($role)) {
            return;
        }
        $this->roles->add($role);
   
        return $this;
    }

    
    public function removeRole(Role $role)
    {
        //$this->roles->removeElement($rol);
        if (!$this->roles->contains($role)) {
            return;
        }
        $this->roles->removeElement($role);   
    }
}

