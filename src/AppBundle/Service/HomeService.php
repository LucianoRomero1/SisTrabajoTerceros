<?php

namespace AppBundle\Service;

use AppBundle\Base\BaseService;
use AppBundle\Base\BaseController;
use AppBundle\Entity\TrabajoCaracteristica;
use AppBundle\Entity\Valvula;
use AppBundle\Entity\PartidasMov;


class HomeService extends BaseService
{   
    private $baseService;

    public function __construct(BaseService $baseService){
        $this->baseService = $baseService;
    }

    public function getCaracteristicas($em){
        $caracteristicas = $em->getRepository(TrabajoCaracteristica::class)->findAll();

        return $caracteristicas;
    }

    // public function getArrayCaracteristicas(){
    //     $arrayCaracteristicas = array(
    //         0 => "Nitrurar",
    //         1 => "PVD - Nitruro de Cromo",
    //         2 => "Mecanizado Final",
    //         3 => "Forja - Tratamiento térmico",
    //         4 => "Huecas a perforar"
    //     );

    //     return $arrayCaracteristicas;
    // }

    public function getAmountByTipoMovimiento($valvulas){
        foreach($valvulas as $valvula){
            dump($valvula->getCodArticulo()->getId());
        }
        die;
    }

    public function getStock($entityManager, $caracteristica){
        
        $connection = $entityManager->getConnection();
        $statement = $connection->prepare(
            'SELECT ARTICULOS.DESCRIP_ABREV,VALVULAS_TRABAJOS_3.COD_DESVIO,VALVULAS_TRABAJOS_3.NRO_PARTIDA, sum(decode(valvulas_trabajos_3.tipo_movimiento,1,cantidad,0)) as envios,sum(decode(valvulas_trabajos_3.tipo_movimiento,3,cantidad,0)) as recibidas,sum(decode(valvulas_trabajos_3.tipo_movimiento,4,cantidad,0)) as devueltas,sum(decode(valvulas_trabajos_3.tipo_movimiento,2,cantidad,0)) as reingresos,min(decode(valvulas_trabajos_3.tipo_movimiento,1,fecha, null)) as primer_envio,max(decode(valvulas_trabajos_3.tipo_movimiento,2,fecha, null)) as ultimo_reingreso FROM VALVULAS_TRABAJOS_3,ARTICULOS WHERE ( VALVULAS_TRABAJOS_3.COD_ARTICULO = ARTICULOS.COD_ARTICULO ) and ( ( VALVULAS_TRABAJOS_3.CARACTERISTICA = ' . $caracteristica . '  ) AND (0 = 0 OR (0 > 0 AND VALVULAS_TRABAJOS_3.COD_ARTICULO = 0)) ) GROUP BY ARTICULOS.DESCRIP_ABREV, VALVULAS_TRABAJOS_3.COD_DESVIO, VALVULAS_TRABAJOS_3.NRO_PARTIDA'
        );

        $statement->execute();
        $resultados = $statement->fetchAll();

        return $resultados;
    }

    public function setValvula($form){
        $valvula = new Valvula();
        $valvula->setId($form['nroRegistro']);
        $valvula->setFecha(new \DateTime($form['fecha']));
        $valvula->setFecha(new \DateTime($form['fecha'])); //Aca es la fecha de grabación en tiempo real
        $valvula->setCodDesvio($form['']);
        $valvula->setNroPartida($form['']);
        $valvula->setTipoMovimiento($form['']); //CREO que es una relacion tambien o deberia hacerla jejejeje
        $valvula->setCodArticulo($form['']); //Este campo lo tengo que sacar de NO SE DONDE LO TENGO QUE SACAR, creo que de la tabla articulos
        $valvula->setCantidad($form['']);
        $valvula->setCodDeposito($form['']); //Relacion
        $valvula->setCodProveedor($form['']); //Relacion
        $valvula->setObservaciones($form['']);
        $valvula->setFechaM($form['']);
        $valvula->setUsuarioM($form['']);
        $valvula->setNroMovPartida($form['']);
        $valvula->setARetrabajar($form['']);
        $valvula->setPttTerminada($form['']);
    }

    public function setPartidasMov($form, $entityManager){
        $partidasMov = new PartidasMov();
        $nroMov = $entityManager->getRepository(PartidasMov::class)->getLastNroMov($form['codDesvio'], $form['nroPartida']);
        
        $partidasMov->setNroMov($nroMov); //Este es el cmapo que tengo que hacer la consulta SQL
        $partidasMov->setNroPartida($form['']);
        $partidasMov->setCodDesvio($form['']);
        $partidasMov->setTipoMovPartida($form['']); //Relacion
        $partidasMov->setFecha($form['']);
        $partidasMov->setArticulo($form['']); //Relacion
        $partidasMov->setCantidad($form['']);
        $partidasMov->setDepoOrigen($form['']);
    }





 
}