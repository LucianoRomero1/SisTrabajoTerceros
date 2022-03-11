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
}