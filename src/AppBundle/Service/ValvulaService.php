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
    
        $amountBasso = 0;
        $amountPi = 0;
        $amountLeh = 0;
        foreach($valvulas as $valvula){

            if($valvula->getCodDeposito()->getid() == 202 || $valvula->getCodDeposito()->getid() == 103){
                //Deposito de  Basso
                $amountBasso++;
            }
            elseif($valvula->getCodDeposito()->getid() == 201 || $valvula->getCodDeposito()->getid() == 301){
                //Deposito de MotorParts P.I
                $amountPi++;
            }
            elseif($valvula->getCodDeposito()->getid() == 100 || $valvula->getCodDeposito()->getid() == 102){
                //Deposito de MotorParts LEH
                $amountLeh++;
            }
            
        }
        
        
    }
}