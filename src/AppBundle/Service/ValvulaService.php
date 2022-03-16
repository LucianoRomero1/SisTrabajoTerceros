<?php

namespace AppBundle\Service;


use AppBundle\Entity\Valvula;
use AppBundle\Entity\Articulo;
use AppBundle\Base\BaseService;
use AppBundle\Base\BaseController;

class ValvulaService extends BaseController
{
    private $baseService;

    public function __construct(BaseService $baseService){
        $this->baseService = $baseService;
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
}