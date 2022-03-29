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
        $amountValvulas          = array("Basso" => 0, "P.I" => 0, "LEH" => 0, "Total" => 0);
        foreach($valvulas as $valvula){
            $idDepo = $valvula->getCodDeposito()->getid();
            if( in_array($idDepo, $idValvulas["Basso"])){
                $amountValvulas["Basso"]++;        
                $amountValvulas["Total"]++; 
            }
            if( in_array($idDepo, $idValvulas["P.I"])){
                $amountValvulas["P.I"]++;
                $amountValvulas["Total"]++; 
            }
            if( in_array($idDepo, $idValvulas["LEH"])){
                $amountValvulas["LEH"]++;
                $amountValvulas["Total"]++; 
            }
            
        }

        return $amountValvulas;
    }

    public function getIdValvulas(){
        $idValvulas["Basso"]     = array(202,103);
        $idValvulas["P.I"]       = array(201,301);
        $idValvulas["LEH"]       = array(100,102);

        return $idValvulas;
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