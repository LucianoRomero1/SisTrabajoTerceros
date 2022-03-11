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
       
        $idValvulas["Basso"]    = array(202,103);
        $idValvulas["Pi"]       = array(201,301);
        $idValvulas["Leh"]      = array(100,102);
        // $amountBasso = 0;
        // $amountPi = 0;
        // $amountLeh = 0;
        foreach($valvulas as $valvula){
            $idDepo = $valvula->getCodDeposito()->getid();
            if( in_array($idDepo, $idValvulas["Basso"])){
                dump("basso");
            }
            if( in_array($idDepo, $idValvulas["Pi"])){
                dump("pi");
            }
            if( in_array($idDepo, $idValvulas["Leh"])){
                dump("lehman");
            }
            
        }
        die;
        
        
    }
}