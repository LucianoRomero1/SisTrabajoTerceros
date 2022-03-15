<?php

namespace AppBundle\Service;

use AppBundle\Base\BaseService;
use AppBundle\Entity\TrabajoCaracteristica;
use AppBundle\Entity\Valvula;


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
}