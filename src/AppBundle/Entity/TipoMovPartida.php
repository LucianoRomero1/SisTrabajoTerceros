<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoMovPartida
 *
 * @ORM\Table(name="neosys.tipo_mov_partidas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoMovPartidaRepository")
 */
class TipoMovPartida
{
    /**
     * @var int
     *
     * @ORM\Column(name="cod_tipo_mov", type="integer")
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
     * @var int
     *
     * @ORM\Column(name="incidencia", type="integer")
     */
    private $incidencia;

    /**
     * @var string
     *
     * @ORM\Column(name="abreviado", type="string", length=255)
     */
    private $abreviado;

    /**
     * @var int
     *
     * @ORM\Column(name="parcial", type="integer")
     */
    private $parcial;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_m", type="string", length=255)
     */
    private $usuarioM;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_m", type="string", length=255)
     */
    private $fechaM;

    /**
     * @var int
     *
     * @ORM\Column(name="orden", type="integer")
     */
    private $orden;


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
     * @return TipoMovPartida
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
     * Set incidencia
     *
     * @param integer $incidencia
     *
     * @return TipoMovPartida
     */
    public function setIncidencia($incidencia)
    {
        $this->incidencia = $incidencia;

        return $this;
    }

    /**
     * Get incidencia
     *
     * @return int
     */
    public function getIncidencia()
    {
        return $this->incidencia;
    }

    /**
     * Set abreviado
     *
     * @param string $abreviado
     *
     * @return TipoMovPartida
     */
    public function setAbreviado($abreviado)
    {
        $this->abreviado = $abreviado;

        return $this;
    }

    /**
     * Get abreviado
     *
     * @return string
     */
    public function getAbreviado()
    {
        return $this->abreviado;
    }

    /**
     * Set parcial
     *
     * @param integer $parcial
     *
     * @return TipoMovPartida
     */
    public function setParcial($parcial)
    {
        $this->parcial = $parcial;

        return $this;
    }

    /**
     * Get parcial
     *
     * @return int
     */
    public function getParcial()
    {
        return $this->parcial;
    }

    /**
     * Set usuarioM
     *
     * @param string $usuarioM
     *
     * @return TipoMovPartida
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
     * @param string $fechaM
     *
     * @return TipoMovPartida
     */
    public function setFechaM($fechaM)
    {
        $this->fechaM = $fechaM;

        return $this;
    }

    /**
     * Get fechaM
     *
     * @return string
     */
    public function getFechaM()
    {
        return $this->fechaM;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return TipoMovPartida
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return int
     */
    public function getOrden()
    {
        return $this->orden;
    }
}

