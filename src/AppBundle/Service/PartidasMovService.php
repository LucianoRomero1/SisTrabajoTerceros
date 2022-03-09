<?php

namespace AppBundle\Service;

use AppBundle\Entity\PartidasMov;
use AppBundle\Base\BaseService;


class PartidasMovService extends BaseService
{   
    private $baseService;

    public function __construct(BaseService $baseService){
        $this->baseService = $baseService;
    }


  
  

}