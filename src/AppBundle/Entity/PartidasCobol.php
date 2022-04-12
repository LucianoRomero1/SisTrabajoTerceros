<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartidasCobol
 *
 * @ORM\Table(name="neosys.partidas_cobol")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartidasCobolRepository")
 */
class PartidasCobol
{

    /**
     * @var int
     *
     * @ORM\Column(name="nro_partida", type="integer")
     * @ORM\Id
     */
    private $nroPartida;

    /**
     * @var int
     *
     * @ORM\Column(name="cod_desvio", type="integer")
     * @ORM\Id
     */
    private $codDesvio;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;



    /**
     * Set nroPartida
     *
     * @param integer $nroPartida
     *
     * @return PartidasCobol
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
     * @param integer $codDesvio
     *
     * @return PartidasCobol
     */
    public function setCodDesvio($codDesvio)
    {
        $this->codDesvio = $codDesvio;

        return $this;
    }

    /**
     * Get codDesvio
     *
     * @return int
     */
    public function getCodDesvio()
    {
        return $this->codDesvio;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return PartidasCobol
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
}

