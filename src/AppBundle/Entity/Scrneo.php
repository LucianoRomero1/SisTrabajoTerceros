<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Scrneo
 *
 * @ORM\Table(name="neosys.scrneo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ScrneoRepository")
 */
class Scrneo
{
    /**
     * @var int
     *
     * @ORM\Column(name="nro_orden", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="odeforja", type="string", length=10)
     */
    private $odeforja;

    /**
     * @var int
     *
     * @ORM\Column(name="lugar", type="integer")
     */
    private $lugar;


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
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Scrneo
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
     * Set odeforja
     *
     * @param string $odeforja
     *
     * @return Scrneo
     */
    public function setOdeforja($odeforja)
    {
        $this->odeforja = $odeforja;

        return $this;
    }

    /**
     * Get odeforja
     *
     * @return string
     */
    public function getOdeforja()
    {
        return $this->odeforja;
    }

    /**
     * Set lugar
     *
     * @param integer $lugar
     *
     * @return Scrneo
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get lugar
     *
     * @return int
     */
    public function getLugar()
    {
        return $this->lugar;
    }
}

