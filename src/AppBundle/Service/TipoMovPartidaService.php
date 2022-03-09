<?php

namespace AppBundle\Service;


use AppBundle\Entity\TipoMovPartida;
use AppBundle\Base\BaseService;

class TipoMovPartidaService extends BaseService
{
    private $baseService;

    public function __construct(BaseService $baseService){
        $this->baseService = $baseService;
    }
}