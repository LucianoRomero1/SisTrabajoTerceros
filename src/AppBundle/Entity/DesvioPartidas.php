<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesvioPartidas
 *
 * @ORM\Table(name="neosys.desvios_partidas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DesvioPartidasRepository")
 */
class DesvioPartidas
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
     * @var string
     *
     * @ORM\Column(name="cod_articulo", type="string", length=255)
     */
    private $codArticulo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * Set nroPartida
     *
     * @param integer $nroPartida
     *
     * @return DesvioPartidas
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
     * @return DesvioPartidas
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
     * Set codArticulo
     *
     * @param string $codArticulo
     *
     * @return DesvioPartidas
     */
    public function setCodArticulo($codArticulo)
    {
        $this->codArticulo = $codArticulo;

        return $this;
    }

    /**
     * Get codArticulo
     *
     * @return string
     */
    public function getCodArticulo()
    {
        return $this->codArticulo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Valvula
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
}

