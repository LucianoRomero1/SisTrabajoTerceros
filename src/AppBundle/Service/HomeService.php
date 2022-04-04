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
    private $mailer;

    public function __construct(BaseService $baseService, \Swift_Mailer $mailer){
        $this->baseService = $baseService;
        $this->mailer       = $mailer;
    }

    public function getCaracteristicas($em){
        $caracteristicas = $em->getRepository(TrabajoCaracteristica::class)->findAll();

        return $caracteristicas;
    }

    public function getArrayCaracteristicas($tipoMovimiento){
        switch($tipoMovimiento){
            case "1":
                $tipoMovimiento = "Nitrurar";
                break;
            case "2":
                $tipoMovimiento = "PVD - Nitruro de Cromo";
                break;
            case "3":
                $tipoMovimiento = "Mecanizado final";
                break;
            case "4":
                $tipoMovimiento = "Forja - Tratamiento térmico";
                break;
            case "5":
                $tipoMovimiento = "Huecas a perforar";
                break;
        }

        return $tipoMovimiento;
    }

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

    public function setValvula($form, $entityManager, $valvula = null){
        if($valvula == null){
            $valvula            = new Valvula();
        }   
        $codArticuloDesvio  = $entityManager->getRepository(DesvioPartidas::class)->findOneBy(array("codDesvio"=>$form['codDesvio'], "nroPartida"=>$form['nroPartida']));
        $codArticulo        = $entityManager->getRepository(Articulo::class)->findOneBy(array("id"=>$codArticuloDesvio->getCodArticulo()));
        $codDeposito        = $entityManager->getRepository(Deposito::class)->findOneBy(array("id"=>$form['codDeposito']));
        $codProveedor       = $entityManager->getRepository(Proveedor::class)->findOneBy(array("id"=>$form['codProveedor']));
        $nroMovArray        = $entityManager->getRepository(PartidasMov::class)->getLastNroMov($form['codDesvio'], $form['nroPartida']);
        $nroMov             = $nroMovArray[1] + 1;
        $caracteristica     = $this->getCaracteristica($form['para']);
        $tipoMov            = $this->getTipoMovimiento($form['tipo']);
        $username           = $this->getUser()->getUsername(); 
        $fechaActual        = $this->baseService->getFechActual();
           

        //$valvula->setNroRegistro($form['nroRegistro']);
        $valvula->setFecha(new \DateTime($form['fecha']));
        $valvula->setFechaM($fechaActual);
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
        $valvula->setCaracteristica($caracteristica);
        $valvula = $this->setCheckBox($valvula, $form);
        
        $entityManager->persist($valvula);
        $entityManager->flush();


    }

    public function setPartidasMov($form, $entityManager, $partidasMov = null){
        $tipoMov            = $this->getTipoMovimiento($form['tipo']);
        if($tipoMov == 1 || $tipoMov == 2){
            if($partidasMov == null){
                $partidasMov            = new PartidasMov();
            }
            $tipoMovPartida     = $this->getTipoMovPartida($tipoMov, $entityManager);
            $nroMovArray        = $entityManager->getRepository(PartidasMov::class)->getLastNroMov($form['codDesvio'], $form['nroPartida']);
            $nroMov             = $nroMovArray[1] + 1;
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
            $valvula->setPttTerminada(1);
        }else{
            $valvula->setPttTerminada(0);
        }
        if(array_key_exists("sinPunta", $form)){
            $valvula->setSinTerminadoPunta(1);
        }else{
            $valvula->setSinTerminadoPunta(0);
        }
        if(array_key_exists("retrabajar", $form)){
            $valvula->setARetrabajar(1);
        }else{
            $valvula->setARetrabajar(0);
        }

        return $valvula;
    }

    public function getCaracteristica($caracteristica){
        switch($caracteristica){
            case "Nitrurar":
                $caracteristica = 1;
                break;
            case "PVD - Nitruro de Cromo":
                $caracteristica = 2;
                break;
            case "Mecanizado final":
                $caracteristica = 3;
                break;
            case "Forja - Tratamiento térmico":
                $caracteristica = 4;
                break;
            case "Huecas a perforar":
                $caracteristica = 5;
                break;
        }

        return $caracteristica;
    }

    public function getArrayRoles($rolesUser){
        $arrayRoles = array(
            "Envio"         => 0,
            "Recepcion"     => 0,
            "Devolucion"    => 0,
            "Reingreso"     => 0,
        );

        foreach($rolesUser as $rol){
            if($rol->getRole() == "ROLE_ENVIO_3°"){
                $arrayRoles["Envio"] = 1;
            }
            if($rol->getRole() == "ROLE_RECEPCION_3°"){
                $arrayRoles["Recepcion"] = 1;
            }
            if($rol->getRole() == "ROLE_DEVOLUCION_3°"){
                $arrayRoles["Devolucion"] = 1;
            }
            if($rol->getRole() == "ROLE_REINGRESO_3°"){
                $arrayRoles["Reingreso"] = 1;
            }
        }

        return $arrayRoles;
    }

    public function envioEmail($form){
        $tipo       = $form['tipo'];
        $para       = $form['para'];
        $valvula    = $form['valvula'];
        $fecha      = $form['fecha'];
        $cantidad   = $form['cantidad'];
        $ptt        = $form['codDesvio'] . $form['nroPartida'];

        $destinatarios  = $this->getReceptores($para); //esta variable la voy a usar cuando compruebe que el email se envia correctamente
        $arrayTxt       = $this->getTituloEmail($para, $tipo);

        $message = \Swift_Message::newInstance()
            ->setSubject($arrayTxt[1])
            ->setFrom("SisTrabajoTerceros@basso.com.ar")
            ->setTo("lromero@basso.com.ar")
            ->setBody(
                $this->renderView(
                    'home/mensaje.html.twig', array(
                        'titulo'    => $arrayTxt[0],
                        'valvula'   => $valvula,
                        'fecha'     => $fecha,
                        'cantidad'  => $cantidad,
                        'ptt'       => $ptt,
                    )
                ),
                'text/html'
        );

       
            
        return $this->mailer->send($message);
    }

    public function getReceptores($para){
        $destinatarios = [];
        //Cuando es Válvula a Nitrurar cambian los email, aplicarlo cuando se reciba la información concreta
        array_push($destinatarios, "atassone@basso.com.ar", "cap@basso.com.ar", "cclementz@basso.com.ar", "fbarberis@basso.com.ar", "insumos@basso.com.ar", "mcerda@basso.com.ar");
        array_push($destinatarios, "mthailinger@basso.com.ar", "mecanizado@basso.com.ar", "pmautino@basso.com.ar", "sspila@basso.com.ar");
        if($para == "Nitrurar"){
            array_push($destinatarios, "nitrurado@mparts.com.ar");
        }

        return $destinatarios;
    }

    public function getTituloEmail($para, $tipo){
        $titulo                 = "";
        $accionTituloEnvio      = "";
        $accionTituloDevolucion = "";
        $asunto                 = "";

        switch($para){
            case "Nitrurar":
                $accionTituloEnvio = "nitrurar";
                break;
            case "PVD - Nitruro de Cromo":
                $accionTituloEnvio = "pvd";
                break;
            case "Mecanizado final":
                $accionTituloEnvio = "mecanizar";
                break;
            case "Forja - Tratamiento térmico":
                $accionTituloEnvio = "tratamiento térmico";
                break;
            case "Huecas a perforar":
                $accionTituloEnvio = "perforar";
                break;
        }

        switch($para){
            case "Nitrurar":
                $accionTituloDevolucion = "nitrurada";
                break;
            case "PVD - Nitruro de Cromo":
                $accionTituloDevolucion = "con pvd";
                break;
            case "Mecanizado final":
                $accionTituloDevolucion = "mecanizada";
                break;
            case "Forja - Tratamiento térmico":
                $accionTituloDevolucion = "con tratamiento térmico";
                break;
            case "Huecas a perforar":
                $accionTituloDevolucion = "perforada";
                break;
        }

        if($tipo == "Envío a 3°"){
            $titulo = "Enviar a $accionTituloEnvio al Parque Industrial la siguiente válvula: ";
            $asunto = "Envío de piezas al PARQUE INDUSTRIAL";
        }
        else{
            $titulo = "Retornar a Basso desde el Parque industrial la siguiente válvula $accionTituloDevolucion: ";
            $asunto = "Envío de piezas de PARQUE INDUSTRIAL a BASSO" ;
        }

        $arrayTxt = [];
        array_push($arrayTxt, $titulo, $asunto);
        
        return $arrayTxt;
    }

   

 
}