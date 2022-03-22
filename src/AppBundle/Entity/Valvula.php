<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Valvula
 *
 * @ORM\Table(name="neosys.valvulas_trabajos_3")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ValvulaRepository")
 */
class Valvula
{
    /**
     * @var int
     *
     * @ORM\Column(name="nro_registro", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_desvio", type="string", length=255)
     */
    private $codDesvio;

    /**
     * @var int
     *
     * @ORM\Column(name="nro_partida", type="integer")
     */
    private $nroPartida;

    /**
     * @var int
     *
     * @ORM\Column(name="tipo_movimiento", type="integer")
     */
    private $tipoMovimiento;

    /**
     * @var int
     *
     * @ORM\Column(name="caracteristica", type="integer")
     */
    private $caracteristica;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    // /**
    //  * @var int
    //  *
    //  * @ORM\Column(name="cod_deposito", type="integer")
    //  */
    // private $codDeposito;

    // /**
    //  * @var int
    //  *
    //  * @ORM\Column(name="cod_proveedor", type="integer")
    //  */
    // private $codProveedor;

    /**
     * var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Deposito")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cod_deposito", referencedColumnName="cod_deposito", nullable=true)
     * })
     */
    private $codDeposito;

    /**
     * var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Proveedor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cod_proveedor", referencedColumnName="cod_proveedor", nullable=true)
     * })
     */
    private $codProveedor;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255)
     */
    private $observaciones;

    /**
     * @var int
     *
     * @ORM\Column(name="cod_comprobante", type="integer")
     */
    private $codComprobante;

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
     * @ORM\Column(name="sin_terminado_punta", type="integer")
     */
    private $sinTerminadoPunta;

    /**
     * @var int
     *
     * @ORM\Column(name="nro_mov_partida", type="integer")
     */
    private $nroMovPartida;

    // /**
    //  * @var int
    //  *
    //  * @ORM\Column(name="cod_articulo", type="integer")
    //  */
    // private $codArticulo;

      /**
     * var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Articulo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cod_articulo", referencedColumnName="cod_articulo", nullable=true)
     * })
     */
    private $codArticulo;

    /**
     * @var int
     *
     * @ORM\Column(name="a_retrabajar", type="integer")
     */
    private $aRetrabajar;

    /**
     * @var int
     *
     * @ORM\Column(name="nro_registro_relacionado", type="integer")
     */
    private $nroRegistroRelacionado;

    /**
     * @var int
     *
     * @ORM\Column(name="cod_celda", type="integer")
     */
    private $codCelda;

    /**
     * @var int
     *
     * @ORM\Column(name="ptt_terminada", type="integer")
     */
    private $pttTerminada;

    /**
     * Set id
     * @param integer $id
     * @return Valvula
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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

    /**
     * Set codDesvio
     *
     * @param string $codDesvio
     *
     * @return Valvula
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
     * Set nroPartida
     *
     * @param integer $nroPartida
     *
     * @return Valvula
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
     * Set tipoMovimiento
     *
     * @param integer $tipoMovimiento
     *
     * @return Valvula
     */
    public function setTipoMovimiento($tipoMovimiento)
    {
        $this->tipoMovimiento = $tipoMovimiento;

        return $this;
    }

    /**
     * Get tipoMovimiento
     *
     * @return int
     */
    public function getTipoMovimiento()
    {
        return $this->tipoMovimiento;
    }

    /**
     * Set caracteristica
     *
     * @param integer $caracteristica
     *
     * @return Valvula
     */
    public function setCaracteristica($caracteristica)
    {
        $this->caracteristica = $caracteristica;

        return $this;
    }

    /**
     * Get caracteristica
     *
     * @return int
     */
    public function getCaracteristica()
    {
        return $this->caracteristica;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Valvula
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

    // /**
    //  * Set codDeposito
    //  *
    //  * @param integer $codDeposito
    //  *
    //  * @return Valvula
    //  */
    // public function setCodDeposito($codDeposito)
    // {
    //     $this->codDeposito = $codDeposito;

    //     return $this;
    // }

    // /**
    //  * Get codDeposito
    //  *
    //  * @return int
    //  */
    // public function getCodDeposito()
    // {
    //     return $this->codDeposito;
    // }

    // /**
    //  * Set codProveedor
    //  *
    //  * @param integer $codProveedor
    //  *
    //  * @return Valvula
    //  */
    // public function setCodProveedor($codProveedor)
    // {
    //     $this->codProveedor = $codProveedor;

    //     return $this;
    // }

    // /**
    //  * Get codProveedor
    //  *
    //  * @return int
    //  */
    // public function getCodProveedor()
    // {
    //     return $this->codProveedor;
    // }

        /**
     * Set codDeposito
     *
     * @param \stdClass $codDeposito
     *
     * @return Valvula
     */
    public function setCodDeposito(\AppBundle\Entity\Deposito $codDeposito = null)
    {
        $this->codDeposito = $codDeposito;

        return $this;
    }

    /**
     * Get codDeposito
     *
     * @return \stdClass
     */
    public function getCodDeposito()
    {
        return $this->codDeposito;
    }

       /**
     * Set codProveedor
     *
     * @param \stdClass $codProveedor
     *
     * @return Valvula
     */
    public function setCodProveedor(\AppBundle\Entity\Proveedor $codProveedor = null)
    {
        $this->codProveedor = $codProveedor;

        return $this;
    }

    /**
     * Get codProveedor
     *
     * @return \stdClass
     */
    public function getCodProveedor()
    {
        return $this->codProveedor;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Valvula
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set codComprobante
     *
     * @param integer $codComprobante
     *
     * @return Valvula
     */
    public function setCodComprobante($codComprobante)
    {
        $this->codComprobante = $codComprobante;

        return $this;
    }

    /**
     * Get codComprobante
     *
     * @return int
     */
    public function getCodComprobante()
    {
        return $this->codComprobante;
    }

    /**
     * Set usuarioM
     *
     * @param string $usuarioM
     *
     * @return Valvula
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
     * @return Valvula
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
     * Set sinTerminadoPunta
     *
     * @param integer $sinTerminadoPunta
     *
     * @return Valvula
     */
    public function setSinTerminadoPunta($sinTerminadoPunta)
    {
        $this->sinTerminadoPunta = $sinTerminadoPunta;

        return $this;
    }

    /**
     * Get sinTerminadoPunta
     *
     * @return int
     */
    public function getSinTerminadoPunta()
    {
        return $this->sinTerminadoPunta;
    }

    /**
     * Set nroMovPartida
     *
     * @param integer $nroMovPartida
     *
     * @return Valvula
     */
    public function setNroMovPartida($nroMovPartida)
    {
        $this->nroMovPartida = $nroMovPartida;

        return $this;
    }

    /**
     * Get nroMovPartida
     *
     * @return int
     */
    public function getNroMovPartida()
    {
        return $this->nroMovPartida;
    }

    // /**
    //  * Set codArticulo
    //  *
    //  * @param integer $codArticulo
    //  *
    //  * @return Valvula
    //  */
    // public function setCodArticulo($codArticulo)
    // {
    //     $this->codArticulo = $codArticulo;

    //     return $this;
    // }

    // /**
    //  * Get codArticulo
    //  *
    //  * @return int
    //  */
    // public function getCodArticulo()
    // {
    //     return $this->codArticulo;
    // }

        /**
     * Set codArticulo
     *
     * @param \stdClass $codArticulo
     *
     * @return Valvula
     */
    public function setCodArticulo(\AppBundle\Entity\Articulo $codArticulo = null)
    {
        $this->codArticulo = $codArticulo;

        return $this;
    }

    /**
     * Get codArticulo
     *
     * @return \stdClass
     */
    public function getCodArticulo()
    {
        return $this->codArticulo;
    }

    /**
     * Set aRetrabajar
     *
     * @param integer $aRetrabajar
     *
     * @return Valvula
     */
    public function setARetrabajar($aRetrabajar)
    {
        $this->aRetrabajar = $aRetrabajar;

        return $this;
    }

    /**
     * Get aRetrabajar
     *
     * @return int
     */
    public function getARetrabajar()
    {
        return $this->aRetrabajar;
    }

    /**
     * Set nroRegistroRelacionado
     *
     * @param integer $nroRegistroRelacionado
     *
     * @return Valvula
     */
    public function setNroRegistroRelacionado($nroRegistroRelacionado)
    {
        $this->nroRegistroRelacionado = $nroRegistroRelacionado;

        return $this;
    }

    /**
     * Get nroRegistroRelacionado
     *
     * @return int
     */
    public function getNroRegistroRelacionado()
    {
        return $this->nroRegistroRelacionado;
    }

    /**
     * Set codCelda
     *
     * @param integer $codCelda
     *
     * @return Valvula
     */
    public function setCodCelda($codCelda)
    {
        $this->codCelda = $codCelda;

        return $this;
    }

    /**
     * Get codCelda
     *
     * @return int
     */
    public function getCodCelda()
    {
        return $this->codCelda;
    }

    /**
     * Set pttTerminada
     *
     * @param integer $pttTerminada
     *
     * @return Valvula
     */
    public function setPttTerminada($pttTerminada)
    {
        $this->pttTerminada = $pttTerminada;

        return $this;
    }

    /**
     * Get pttTerminada
     *
     * @return int
     */
    public function getPttTerminada()
    {
        return $this->pttTerminada;
    }
}

