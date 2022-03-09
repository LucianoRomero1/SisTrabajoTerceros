<?php

namespace AppBundle\Service;

use AppBundle\Entity\Valvula;
use AppBundle\Base\BaseService;

class ValvulaService 
{
    private $baseService;

    public function __construct(BaseService $baseService){
        $this->baseService = $baseService;
    }
}