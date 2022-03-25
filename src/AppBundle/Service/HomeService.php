<?php

namespace AppBundle\Service;

use AppBundle\Base\BaseService;
use AppBundle\Entity\TrabajoCaracteristica;
use AppBundle\Entity\Valvula;
use AppBundle\Entity\PartidasMov;
use AppBundle\Entity\DesvioPartidas;
use AppBundle\Entity\Deposito;
use AppBundle\Entity\Proveedor;
use AppBundle\Entity\Articulo;
use AppBundle\Entity\TipoMovPartida;

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

    public function setValvula($form, $entityManager){
        $valvula            = new Valvula();
        $codArticuloDesvio  = $entityManager->getRepository(DesvioPartidas::class)->findOneBy(array("codDesvio"=>$form['codDesvio'], "nroPartida"=>$form['nroPartida']));
        $codArticulo        = $entityManager->getRepository(Articulo::class)->findOneBy(array("id"=>$codArticuloDesvio->getCodArticulo()));
        $codDeposito        = $entityManager->getRepository(Deposito::class)->findOneBy(array("id"=>$form['codDeposito']));
        $codProveedor       = $entityManager->getRepository(Proveedor::class)->findOneBy(array("id"=>$form['codProveedor']));
        $nroMov             = $entityManager->getRepository(PartidasMov::class)->getLastNroMov($form['codDesvio'], $form['nroPartida']);
        $tipoMov            = $this->getTipoMovimiento($form['tipo']);
        $username           = $this->getUser()->getUsername(); 

        $valvula->setId($form['nroRegistro']);
        $valvula->setFecha(new \DateTime($form['fecha']));
        $valvula->setFechaM($this->baseService->getFechActual());
        $valvula->setCodDesvio($form['codDesvio']);
        $valvula->setNroPartida($form['nroPartida']);
        $valvula->setTipoMovimiento($tipoMov);
        $valvula->setCodArticulo($codArticulo); 
        $valvula->setCantidad($form['cantidad']);
        $valvula->setCodDeposito($codDeposito); 
        $valvula->setCodProveedor($codProveedor); 
        $valvula->setObservaciones($form['observaciones']);
        $valvula->setUsuarioM($username); 
        $valvula->setNroMovPartida($nroMov);
        $valvula = $this->setCheckBox($valvula, $form);
        
        $entityManager->persist($valvula);
        $entityManager->flush();

    }

    public function setPartidasMov($form, $entityManager){
        $tipoMov            = $this->getTipoMovimiento($form['tipo']);
        if($tipoMov == 1 || $tipoMov == 2){
            $partidasMov        = new PartidasMov();
            $tipoMovPartida     = $this->getTipoMovPartida($tipoMov, $entityManager);
            $nroMov             = $entityManager->getRepository(PartidasMov::class)->getLastNroMov($form['codDesvio'], $form['nroPartida']);
            $codArticuloDesvio  = $entityManager->getRepository(DesvioPartidas::class)->findOneBy(array("codDesvio"=>$form['codDesvio'], "nroPartida"=>$form['nroPartida']));
            $codArticulo        = $entityManager->getRepository(Articulo::class)->findOneBy(array("id"=>$codArticuloDesvio->getCodArticulo()));
            
            $partidasMov->setNroPartida($form['nroPartida']);
            $partidasMov->setCodDesvio($form['codDesvio']);
            $partidasMov->setNroMov($nroMov); 
            $partidasMov->setTipoMovPartida($tipoMovPartida); 
            $partidasMov->setFecha(new \DateTime($form['fecha']));
            $partidasMov->setArticulo($codArticulo);
            $partidasMov->setCantidad($form['cantidad']);
            $partidasMov->setDepoOrigen($form['codDeposito']);

            $entityManager->persist($partidasMov);
            $entityManager->flush();
        }
        
    }


    public function getTipoMovPartida($tipoMov, $entityManager){
        if($tipoMov == 1){
            $tipoMovPartida     = $entityManager->getRepository(TipoMovPartida::class)->findOneBy(array("id"=>"9"));
        }
        if($tipoMov == 2){
            $tipoMovPartida     = $entityManager->getRepository(TipoMovPartida::class)->findOneBy(array("id"=>"7"));
        }

        return $tipoMovPartida;
        
    }


    public function getTipoMovimiento($tipoMov){
        switch($tipoMov){
            case "Envío a 3°":
                $tipoMov = 1;
                break;
            case "Recepción de 3°":
                $tipoMov = 2;
                break;
            case "Recepción en 3°":
                $tipoMov = 3;
                break;
            case "Devolución de 3°":
                $tipoMov = 4;
                break;
        }
        return $tipoMov;
    }
    
    public function setCheckBox($valvula, $form){
        if(array_key_exists("ppt", $form)){
            $valvula->setPttTerminada($form['ppt']);
        }else{
            $valvula->setPttTerminada(0);
        }
        if(array_key_exists("sinPunta", $form)){
            $valvula->setSinTerminadoPunta($form['sinPunta']);
        }else{
            $valvula->setSinTerminadoPunta(0);
        }
        if(array_key_exists("retrabajar", $form)){
            $valvula->setARetrabajar($form['retrabajar']);
        }else{
            $valvula->setARetrabajar(0);
        }

        return $valvula;
    }



 
}