<?php

namespace AppBundle\Service;

use AppBundle\Entity\TrabajoCaracteristica;
use AppBundle\Base\BaseService;

class TrabajoCaracteristicaService
{
    private $baseService;

    public function __construct(BaseService $baseService){
        $this->baseService = $baseService;
    }
}