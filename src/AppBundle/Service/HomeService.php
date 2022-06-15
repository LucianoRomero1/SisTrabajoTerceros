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
use AppBundle\Entity\PartidasCobol;
use AppBundle\Entity\Scrneo;
use AppBundle\Entity\Usuario;

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
            'SELECT ARTICULOS.DESCRIP_ABREV,VALVULAS_TRABAJOS_3.COD_DESVIO,VALVULAS_TRABAJOS_3.NRO_PARTIDA, sum(decode(valvulas_trabajos_3.tipo_movimiento,1,cantidad,0)) as envios,sum(decode(valvulas_trabajos_3.tipo_movimiento,3,cantidad,0)) as recibidas,sum(decode(valvulas_trabajos_3.tipo_movimiento,4,cantidad,0)) as devueltas,sum(decode(valvulas_trabajos_3.tipo_movimiento,2,cantidad,0)) as reingresos,min(decode(valvulas_trabajos_3.tipo_movimiento,1,fecha, null)) as primer_envio,max(decode(valvulas_trabajos_3.tipo_movimiento,2,fecha, null)) as ultimo_reingreso FROM VALVULAS_TRABAJOS_3,ARTICULOS, DEPOSITOS WHERE ( VALVULAS_TRABAJOS_3.COD_ARTICULO = ARTICULOS.COD_ARTICULO ) and ( ( VALVULAS_TRABAJOS_3.CARACTERISTICA = ' . $caracteristica . '  ) AND (0 = 0 OR (0 > 0 AND VALVULAS_TRABAJOS_3.COD_ARTICULO = 0)) and (VALVULAS_TRABAJOS_3.COD_DEPOSITO = DEPOSITOS.COD_DEPOSITO) ) GROUP BY ARTICULOS.DESCRIP_ABREV, VALVULAS_TRABAJOS_3.COD_DESVIO, VALVULAS_TRABAJOS_3.NRO_PARTIDA'
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
        $valvula->setCaracteristica($caracteristica);
        $valvula->setCodArticulo($codArticulo); 
        $valvula->setCantidad($form['cantidad']);
        $valvula->setCodDeposito($codDeposito); 
        $valvula->setCodProveedor($codProveedor); 
        $valvula->setObservaciones($form['observaciones']);
        $valvula->setUsuarioM($username); 
        if($tipoMov == 1 || $tipoMov == 2){
            $valvula->setNroMovPartida($nroMov);
        }
        else{
            $valvula->setNroMovPartida(null);
        }     
        $valvula = $this->setCheckBox($valvula, $form);

        //Esto es importante para la DB de produccion, es para evitar errores con las secuencias
        // $entityManager->persist($valvula);

        // $id         = $valvula->getId(); 
        // $idNuevo    = $entityManager->getRepository(Valvula::class)->getCountValvulas();

        // if($idNuevo > $id){
        //     $diff = intval($idNuevo[1]) - $id;
        //     $connection = $entityManager->getConnection();
        //     for($i = 1; $i <= $diff; $i++){
        //         $statement = $connection->prepare(
        //             'SELECT neosys.valvulas_trabajos_3_nro.nextval from dual'
        //         );
        //         $statement->execute();
        //         $resultados[] = $statement->fetchAll();
        //     }

        //     $entityManager->persist($valvula);
        // }

        
        // $entityManager->flush();

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
            'Consulta'      => 0
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
            if($rol->getRole() == "ROLE_CONSULTA"){
                $arrayRoles["Consulta"] = 1;
            }
        }

        return $arrayRoles;
    }

    public function envioEmail($form, $entityManager){
        $tipo           = $form['tipo'];
        $para           = $form['para'];
        $valvula        = $form['valvula'];
        $fecha          = $form['fecha'];
        $cantidad       = $form['cantidad'];
        $ptt            = $form['codDesvio'] . $form['nroPartida'];
        $codDepo        = $form['codDeposito'];
        $observaciones  = null;
        $pttCheck       = null;
        $retrabajar     = null;

        if(array_key_exists("ppt", $form)){
            $pttCheck   = $form['ppt'];
        }
        if(array_key_exists("retrabajar", $form)){
            $retrabajar   = $form['retrabajar'];
        }
        if(array_key_exists("observaciones", $form)){
            $observaciones   = $form['observaciones'];
        }

        if($para == "Nitrurar"){
            $destinatarios  = $this->getReceptoresNitrurar($entityManager);       
        }
        if($para == "Huecas a perforar"){
            $destinatarios  = $this->getReceptoresHuecas($entityManager); 
        }
        if($para != "Nitrurar" && $para != "Huecas a perforar"){
            $destinatarios  = $this->getReceptores($para, $entityManager);
        }

        $caracteristica = $this->getCaracteristica($para);
        $valvulaEnviada = $entityManager->getRepository(Valvula::class)->findOneBy(array("codDesvio"=>$form['codDesvio'], "nroPartida"=>$form['nroPartida'],"caracteristica"=>$caracteristica, "tipoMovimiento"=>1));
        $depoValvula    = $valvulaEnviada->getCodDeposito()->getDescripcion();

        $arrayTxt        = $this->getTituloEmail($para, $tipo, $depoValvula);

        $message = \Swift_Message::newInstance()
            ->setSubject($arrayTxt[1])
            ->setFrom("SisTrabajoTerceros@basso.com.ar")
            //->setTo($destinatarios)
            ->setTo("lromero@basso.com.ar")
            ->setBody(
                $this->renderView(
                    'home/mensaje.html.twig', array(
                        'titulo'        => $arrayTxt[0],
                        'valvula'       => $valvula,
                        'fecha'         => $fecha,
                        'cantidad'      => $cantidad,
                        'ptt'           => $ptt,
                        'pttCheck'      => $pttCheck  ,
                        'retrabajar'    => $retrabajar,
                        'observaciones' => $observaciones
                    )
                ),
                'text/html'
        );

       
            
        return $this->mailer->send($message);
    }

    public function getReceptoresNitrurar($entityManager){
        $destinatarios  = [];
        $emailEmisor    = $this->getEmisor($entityManager);
        array_push($destinatarios, "nitrurado@mparts.com.ar","mecanizadopi@mparts.com.ar", "mecanizado@basso.com.ar", "ifinal@basso.com.ar", "wsalva@basso.com.ar", "insumos@basso.com.ar", "dricciardino@basso.com.ar");
        array_push($destinatarios, "mcerda@basso.com.ar", "fbarberis@basso.com.ar", "cclementz@basso.com.ar", "jleonardi@basso.com.ar", "fverbeke@basso.com.ar", "cap@basso.com.ar");
        array_push($destinatarios, $emailEmisor);

        return $destinatarios;
    }

    public function getReceptoresHuecas($entityManager){
        $destinatarios  = [];
        $emailEmisor    = $this->getEmisor($entityManager);
        array_push($destinatarios, "dchiabrando@basso.com.ar","lboggero@basso.com.ar", "insumos@basso.com.ar");
        array_push($destinatarios, "mcerda@basso.com.ar", "fbarberis@basso.com.ar", "cclementz@basso.com.ar", "jleonardi@basso.com.ar", "fverbeke@basso.com.ar", "cap@basso.com.ar");
        array_push($destinatarios, $emailEmisor);

        return $destinatarios;
    }

    public function getEmisor($entityManager){
        $emisor    = $entityManager->getRepository(Usuario::class)->findOneBy(array("username"=>$this->getUser()->getUsername()));
        if(is_null($emisor->getEmail())){
            $emailEmisor = $emisor->getUsername() . '@basso.com.ar';
        }
        else{
            $emailEmisor = $emisor->getEmail();
        }

        return $emailEmisor;
    }

    public function getReceptores($para, $entityManager){
        $destinatarios  = [];
        $emailEmisor    = $this->getEmisor($entityManager);
        
        //Cuando es Válvula a Nitrurar cambian los email, aplicarlo cuando se reciba la información concreta
        array_push($destinatarios, "atassone@basso.com.ar", "cap@basso.com.ar", "cclementz@basso.com.ar", "fbarberis@basso.com.ar", "insumos@basso.com.ar", "mcerda@basso.com.ar");
        array_push($destinatarios, "mthailinger@basso.com.ar", "mecanizado@basso.com.ar");
        array_push($destinatarios, $emailEmisor); //Este emailEmisor, es el email de la persona logueada que hace la accion
        if($para == "Nitrurar"){
            array_push($destinatarios, "nitrurado@mparts.com.ar");
        }

        return $destinatarios;
    }

    public function getTituloEmail($para, $tipo, $depoValvula){
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
            $titulo = "Retornar a " . $depoValvula . " desde el Parque Industrial la siguiente válvula $accionTituloDevolucion: ";
            $asunto = "Envío de piezas de PARQUE INDUSTRIAL a BASSO" ;
        }

        $arrayTxt = [];
        array_push($arrayTxt, $titulo, $asunto);
        
        return $arrayTxt;
    }

    public function getPeriodoActual(){
        $fechaActual    = $this->baseService->getFechActual();
        $result         = $fechaActual->format('Y-m-d');
        $fechaActual    = date_parse_from_format("Y-m-d", $result);

        $mes            = $this->mesToString($fechaActual["month"]);
        $anio           = $fechaActual["year"];

        $periodo = [];
        array_push($periodo, $mes, $anio);

        return $periodo;
    }

    public function mesToString($mes){
        $months = [
            'Enero', 
            'Febrero', 
            'Marzo',
            'Abril', 
            'Mayo', 
            'Junio',
            'Julio', 
            'Agosto', 
            'Septiembre',
            'Octubre', 
            'Noviembre', 
            'Diciembre'
        ];

        $mes = $months[$mes - 1];

        return $mes;
    }

    public function getStockPara($entityManager){
        
        $connection = $entityManager->getConnection();
        for($i = 1; $i <= 5; $i++){
            $statement = $connection->prepare(
                'SELECT nvl(sum(decode(tipo_movimiento,1,cantidad,0)), 0) as enviadas, nvl(sum(decode(tipo_movimiento,2,cantidad,0)), 0) as reingresadas from valvulas_trabajos_3 where extract(month from fecha) = extract(month from sysdate) and extract(year from fecha) = extract(year from sysdate) and caracteristica =' . $i
            );
            $statement->execute();
            $resultados[] = $statement->fetchAll();
        }
        
        return $resultados;
    }

    public function sinTerminadoPunta($entityManager, $codArticulo){
        $connection = $entityManager->getConnection();
        $statement = $connection->prepare(
            "SELECT decode(p1.valor,0,p2.valor, p1.valor) as valor
            from
            (select cod_producto, nvl(valor,0) as valor
            from atributos_producto
            where cod_producto = (select cod_producto from articulos where cod_articulo = $codArticulo)
                  and cod_atributo = 20) p1,
            (select cod_producto, nvl(nit_pta_pla,0) as valor
            from productos
            where cod_producto = (select cod_producto from articulos where cod_articulo = $codArticulo)) p2
            where p1.cod_producto = p2.cod_producto"
        );

        $statement->execute();
        $resultados = $statement->fetchAll();

        return $resultados;
    }

    public function getCantidad($tipo, $caracteristica, $nroPartida, $codDesvio, $entityManager){
        $tipoMov = 0;
        $caracteristica = $this->getCaracteristica($caracteristica);
        switch($tipo){
            case 'envio':
                //Envio
                $tipoMov = 1;
                break;
            case 'recepcion':
                //Recepcion de 3°
                $tipoMov = 3;
                break;
            case 'reingreso':
                //Recepcion en 3°
                $tipoMov = 2;
                break;
            case 'devolucion':
                //Devolucion de 3°
                $tipoMov = 4;
                break;
        }


        $cantidadAMostrar = $this->getCantidadAMostrar($tipoMov, $nroPartida, $codDesvio, $caracteristica, $entityManager);
        
        return $cantidadAMostrar;
    }

    public function getValvulaTercero($entityManager, $nroPartida, $codDesvio, $caracteristica, $tipoMov){
        
        $valvula = $entityManager->getRepository(Valvula::class)->findBy(array("nroPartida"=>$nroPartida, "codDesvio"=>$codDesvio, 'caracteristica'=>$caracteristica, 'tipoMovimiento'=>$tipoMov));
        if(is_null($valvula)){
            $valvula = 0;
        }

        return $valvula;
    }

    

    public function getCantidadAMostrar($tipoMov, $nroPartida, $codDesvio, $caracteristica, $entityManager){
        $cantidadAMostrar = 0;

        if($tipoMov == 1){
            //Envio
            $cantidadInicial    = $entityManager->getRepository(PartidasCobol::class)->findOneBy(array('nroPartida'=>$nroPartida, 'codDesvio'=>$codDesvio))->getCantidad();
            $cantidadValvula    = $this->getCantidadConsulta($entityManager, $codDesvio, $nroPartida, $tipoMov, $caracteristica);

            $cantidadAMostrar   = $cantidadInicial - $cantidadValvula[0]["CANTIDAD"];
            //Si es envio y es nitrurar tengo que buscar en la tabla scrneo y descontarle las 
            //que estan en SCRAP
            if($caracteristica == 1){
                $cantidadScrap = $this->getCantidadScrap($entityManager, $codDesvio, $nroPartida);
                $cantidadAMostrar -= $cantidadScrap;
            }

        }

        if($tipoMov == 3){
            //Recepcion en 3°
            $cantidadInicial = 0;
            $cantidadValvula = 0;
            $valvulaAnterior = $this->getCantidadConsulta($entityManager, $codDesvio, $nroPartida, 1 , $caracteristica);
            $valvulaActual   = $this->getCantidadConsulta($entityManager, $codDesvio, $nroPartida, $tipoMov , $caracteristica);

            $cantidadAMostrar = $valvulaAnterior[0]["CANTIDAD"] - $valvulaActual[0]["CANTIDAD"];
        }

        if($tipoMov == 4){
            //Devolucion
            $cantidadInicial = 0;
            $cantidadValvula = 0;
            $valvulaAnterior = $this->getCantidadConsulta($entityManager, $codDesvio, $nroPartida, 3 , $caracteristica);
            $valvulaActual   = $this->getCantidadConsulta($entityManager, $codDesvio, $nroPartida, $tipoMov , $caracteristica);

            $cantidadAMostrar = $valvulaAnterior[0]["CANTIDAD"] - $valvulaActual[0]["CANTIDAD"];
        }

        if($tipoMov == 2){
            //Reingreso
            $cantidadInicial = 0;
            $cantidadValvula = 0;
            $valvulaAnterior = $this->getCantidadConsulta($entityManager, $codDesvio, $nroPartida, 4 , $caracteristica);
            $valvulaActual   = $this->getCantidadConsulta($entityManager, $codDesvio, $nroPartida, $tipoMov , $caracteristica);

            $cantidadAMostrar = $valvulaAnterior[0]["CANTIDAD"] - $valvulaActual[0]["CANTIDAD"];

        }

        if($cantidadAMostrar < 0){
            $cantidadAMostrar = 0;
        }

        return $cantidadAMostrar;
    }

    public function getCantidadConsulta($entityManager, $codDesvio, $nroPartida, $tipoMov, $caracteristica){
        $connection = $entityManager->getConnection();
        $statement = $connection->prepare(
            "SELECT sum(cantidad) as cantidad from valvulas_trabajos_3 where cod_desvio = $codDesvio and nro_partida = $nroPartida and tipo_movimiento = $tipoMov and caracteristica = $caracteristica"
        );

        $statement->execute();
        $resultados = $statement->fetchAll();

        return $resultados;
    }

    public function getCantidadInicial($entityManager, $codDesvio, $nroPartida){
        $connection = $entityManager->getConnection();
        $statement = $connection->prepare(
            "SELECT sum(cantidad) as cantidad from partidas_cobol where cod_desvio = $codDesvio and nro_partida = $nroPartida"
        );

        $statement->execute();
        $resultados = $statement->fetchAll();

        return $resultados;
    }

    public function getCantidadScrap($entityManager, $codDesvio, $nroPartida){
        $cantidadScrap  = 0;
        $odeforja       = $codDesvio . $nroPartida;
        $scrneo         = $entityManager->getRepository(Scrneo::class)->findBy(array("odeforja"=>$odeforja, "lugar"=>2));
        foreach($scrneo as $scr){
            $cantidadScrap += $scr->getCantidad();
        }

        return $cantidadScrap;
    }
}