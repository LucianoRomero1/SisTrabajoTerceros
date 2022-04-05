<?php

namespace AppBundle\Service;


use AppBundle\Entity\Valvula;
use AppBundle\Entity\Articulo;
use AppBundle\Entity\DesvioPartidas;
use AppBundle\Entity\Deposito;
use AppBundle\Entity\Proveedor;
use AppBundle\Entity\PartidasMov;
use AppBundle\Base\BaseService;
use AppBundle\Base\BaseController;
use AppBundle\Service\HomeService;

class ValvulaService extends BaseController
{
    private $baseService;
    private $homeService;

    public function __construct(BaseService $baseService, HomeService $homeService){
        $this->baseService = $baseService;
        $this->homeService = $homeService;
    }

    public function getValuesAnotherTable(){
        $em = $this->getEm();

        return $em->getRepository(Articulo::class)->findAll();
    }

    public function getAmountValvula($valvulas){
       
        $idValvulas = $this->getIdValvulas();
        $recordsValvulas          = array("Basso" => 0, "P.I" => 0, "LEH" => 0, "Total" => 0);
        $amountValvulas           = array("Basso" => 0, "P.I" => 0, "LEH" => 0, "Total" => 0);
        
        foreach($valvulas as $valvula){
            $idDepo = $valvula->getCodDeposito()->getid();
            if( in_array($idDepo, $idValvulas["Basso"])){
                $recordsValvulas = $this->addRecords($recordsValvulas, "Basso");
                $amountValvulas  = $this->addAmount($amountValvulas, "Basso", $valvula->getCantidad());
            }
            if( in_array($idDepo, $idValvulas["P.I"])){
                $recordsValvulas = $this->addRecords($recordsValvulas, "P.I");
                $amountValvulas  = $this->addAmount($amountValvulas, "P.I", $valvula->getCantidad());
            }
            if( in_array($idDepo, $idValvulas["LEH"])){
                $recordsValvulas = $this->addRecords($recordsValvulas, "LEH");
                $amountValvulas  = $this->addAmount($amountValvulas, "LEH", $valvula->getCantidad());
            }
            
        }

        $arrayResult = [];
        array_push($arrayResult, $recordsValvulas, $amountValvulas);

        return $arrayResult;
    }

    public function getIdValvulas(){
        $idValvulas["Basso"]     = array(202,103);
        $idValvulas["P.I"]       = array(201,301);
        $idValvulas["LEH"]       = array(100,102);

        return $idValvulas;
    }

    public function addRecords($array, $pos){
        $array[$pos]++;
        $array["Total"]++;

        return $array;
    }

    public function addAmount($array, $pos, $cantidad){
        $array[$pos]    += $cantidad;
        $array["Total"] += $cantidad;

        return $array;
    }

    public function getData($entityManager, $id){
        $array              = [];
        $valvula            = $entityManager->getRepository(Valvula::class)->find($id); 
        $codArticulo        = $entityManager->getRepository(Articulo::class)->findOneBy(array("id"=>$valvula->getCodArticulo()));
        $nroMov             = $valvula->getNroMovPartida();
        $codDesvio          = $valvula->getCodDesvio();
        $nroPartida         = $valvula->getNroPartida();     

        //Lo busco por todos esos campos a la partida MOV para asegurarme que sea ese
        $partidaMov         = $entityManager->getRepository(PartidasMov::class)->findOneBy(array("nroMov"=>$nroMov, 'codDesvio'=>$codDesvio, 'nroPartida'=>$nroPartida, 'articulo'=>$codArticulo));
        $nroRegistro        = $entityManager->getRepository(Valvula::class)->getCountValvulas($entityManager);

        array_push($array, $valvula, $partidaMov, $nroRegistro);
        
        return $array;
        
    }


}