<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrabajoCaracteristica
 *
 * @ORM\Table(name="neosys.trabajos_caracteristicas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrabajoCaracteristicaRepository")
 */
class TrabajoCaracteristica
{
    /**
     * @var int
     *
     * @ORM\Column(name="cod_trabajo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_m", type="string", length=255)
     */
    private $usuarioM;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_m", type="datetime")
     */
    private $fechaM;

    /**
     * @var int
     *
     * @ORM\Column(name="vuelve", type="integer")
     */
    private $vuelve;

    /**
     * @var int
     *
     * @ORM\Column(name="tipo_mov_envio", type="integer")
     */
    private $tipoMovEnvio;

    /**
     * @var int
     *
     * @ORM\Column(name="tipo_mov_regreso", type="integer")
     */
    private $tipoMovRegreso;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return TrabajoCaracteristica
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set usuarioM
     *
     * @param string $usuarioM
     *
     * @return TrabajoCaracteristica
     */
    public function setUsuarioM($usuarioM)
    {
        $this->usuarioM = $usuarioM;

        return $this;
    }

    /**
     * Get usuarioM
     *
     * @return string
     */
    public function getUsuarioM()
    {
        return $this->usuarioM;
    }

    /**
     * Set fechaM
     *
     * @param \DateTime $fechaM
     *
     * @return TrabajoCaracteristica
     */
    public function setFechaM($fechaM)
    {
        $this->fechaM = $fechaM;

        return $this;
    }

    /**
     * Get fechaM
     *
     * @return \DateTime
     */
    public function getFechaM()
    {
        return $this->fechaM;
    }

    /**
     * Set vuelve
     *
     * @param integer $vuelve
     *
     * @return TrabajoCaracteristica
     */
    public function setVuelve($vuelve)
    {
        $this->vuelve = $vuelve;

        return $this;
    }

    /**
     * Get vuelve
     *
     * @return int
     */
    public function getVuelve()
    {
        return $this->vuelve;
    }

    /**
     * Set tipoMovEnvio
     *
     * @param integer $tipoMovEnvio
     *
     * @return TrabajoCaracteristica
     */
    public function setTipoMovEnvio($tipoMovEnvio)
    {
        $this->tipoMovEnvio = $tipoMovEnvio;

        return $this;
    }

    /**
     * Get tipoMovEnvio
     *
     * @return int
     */
    public function getTipoMovEnvio()
    {
        return $this->tipoMovEnvio;
    }

    /**
     * Set tipoMovRegreso
     *
     * @param integer $tipoMovRegreso
     *
     * @return TrabajoCaracteristica
     */
    public function setTipoMovRegreso($tipoMovRegreso)
    {
        $this->tipoMovRegreso = $tipoMovRegreso;

        return $this;
    }

    /**
     * Get tipoMovRegreso
     *
     * @return int
     */
    public function getTipoMovRegreso()
    {
        return $this->tipoMovRegreso;
    }
}

