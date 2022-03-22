<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\TipoMovPartida;
use AppBundle\Entity\Articulo;

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
     */
    private $nroPartida;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_desvio", type="string", length=255)
     * @ORM\Id
     */
    private $codDesvio;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="TipoMovPartida")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cod_tipo_mov", referencedColumnName="cod_tipo_mov", nullable=false)
     * })
     */
    private $tipoMovPartida;

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
     * @ORM\Id
     */
    private $nroMov;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Articulo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cod_articulo", referencedColumnName="cod_articulo", nullable=false)
     * })
     */
    private $articulo;

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
     * Set nroPartida
     *
     * @param string $nroPartida
     *
     * @return PartidasMov
     */
    public function setNroPartida($nroPartida)
    {
        $this->nroPartida = $nroPartida;

        return $this;
    }
    
    /**
     * Get nroPartida
     *
     * @return int
     */
    public function getNroPartida()
    {
        return $this->nroPartida;
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
     * Set tipoMovPartida
     *
     * @param TipoMovPartida $tipoMovPartida
     *
     * @return PartidasMov
     */
    public function setTipoMovPartida(TipoMovPartida $tipoMovPartida = null )
    {
        $this->tipoMovPartida = $tipoMovPartida;

        return $this;
    }

    /**
     * Get tipoMovPartida
     *
     * @return TipoMovPartida
     */
    public function getTipoMovPartida()
    {
        return $this->tipoMovPartida;
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
     * Set articulo
     *
     * @param integer $articulo
     *
     * @return PartidasMov
     */
    public function setArticulo(Articulo $articulo = null)
    {
        $this->articulo = $articulo;

        return $this;
    }

    /**
     * Get articulo
     *
     * @return int
     */
    public function getArticulo()
    {
        return $this->articulo;
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

