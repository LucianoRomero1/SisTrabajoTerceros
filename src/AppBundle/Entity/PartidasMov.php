<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartidasMov
 *
 * @ORM\Table(name="neosys.partidas_mov")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartidasMovRepository")
 */
class PartidasMov
{
    /**
     * @var int
     *
     * @ORM\Column(name="nro_partida", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_desvio", type="string", length=255)
     */
    private $codDesvio;

    /**
     * @var int
     *
     * @ORM\Column(name="cod_tipo_mov", type="integer")
     */
    private $codTipoMov;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="nro_mov", type="integer")
     */
    private $nroMov;

    /**
     * @var int
     *
     * @ORM\Column(name="cod_articulo", type="integer")
     */
    private $codArticulo;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="valv_desv", type="string", length=255)
     */
    private $valvDesvio;

    /**
     * @var int
     *
     * @ORM\Column(name="depo_origen", type="integer")
     */
    private $depoOrigen;

    /**
     * @var int
     *
     * @ORM\Column(name="ind_proc_partida", type="integer")
     */
    private $indProcPartida;

    /**
     * @var int
     *
     * @ORM\Column(name="cod_cpte", type="integer")
     */
    private $codCpte;


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
     * Set codDesvio
     *
     * @param string $codDesvio
     *
     * @return PartidasMov
     */
    public function setCodDesvio($codDesvio)
    {
        $this->codDesvio = $codDesvio;

        return $this;
    }

    /**
     * Get codDesvio
     *
     * @return string
     */
    public function getCodDesvio()
    {
        return $this->codDesvio;
    }

    /**
     * Set codTipoMov
     *
     * @param integer $codTipoMov
     *
     * @return PartidasMov
     */
    public function setCodTipoMov($codTipoMov)
    {
        $this->codTipoMov = $codTipoMov;

        return $this;
    }

    /**
     * Get codTipoMov
     *
     * @return int
     */
    public function getCodTipoMov()
    {
        return $this->codTipoMov;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return PartidasMov
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set nroMov
     *
     * @param integer $nroMov
     *
     * @return PartidasMov
     */
    public function setNroMov($nroMov)
    {
        $this->nroMov = $nroMov;

        return $this;
    }

    /**
     * Get nroMov
     *
     * @return int
     */
    public function getNroMov()
    {
        return $this->nroMov;
    }

    /**
     * Set codArticulo
     *
     * @param integer $codArticulo
     *
     * @return PartidasMov
     */
    public function setCodArticulo($codArticulo)
    {
        $this->codArticulo = $codArticulo;

        return $this;
    }

    /**
     * Get codArticulo
     *
     * @return int
     */
    public function getCodArticulo()
    {
        return $this->codArticulo;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return PartidasMov
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return int
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set valvDesvio
     *
     * @param string $valvDesvio
     *
     * @return PartidasMov
     */
    public function setValvDesvio($valvDesvio)
    {
        $this->valvDesvio = $valvDesvio;

        return $this;
    }

    /**
     * Get valvDesvio
     *
     * @return string
     */
    public function getValvDesvio()
    {
        return $this->valvDesvio;
    }

    /**
     * Set depoOrigen
     *
     * @param integer $depoOrigen
     *
     * @return PartidasMov
     */
    public function setDepoOrigen($depoOrigen)
    {
        $this->depoOrigen = $depoOrigen;

        return $this;
    }

    /**
     * Get depoOrigen
     *
     * @return int
     */
    public function getDepoOrigen()
    {
        return $this->depoOrigen;
    }

    /**
     * Set indProcPartida
     *
     * @param integer $indProcPartida
     *
     * @return PartidasMov
     */
    public function setIndProcPartida($indProcPartida)
    {
        $this->indProcPartida = $indProcPartida;

        return $this;
    }

    /**
     * Get indProcPartida
     *
     * @return int
     */
    public function getIndProcPartida()
    {
        return $this->indProcPartida;
    }

    /**
     * Set codCpte
     *
     * @param integer $codCpte
     *
     * @return PartidasMov
     */
    public function setCodCpte($codCpte)
    {
        $this->codCpte = $codCpte;

        return $this;
    }

    /**
     * Get codCpte
     *
     * @return int
     */
    public function getCodCpte()
    {
        return $this->codCpte;
    }
}

