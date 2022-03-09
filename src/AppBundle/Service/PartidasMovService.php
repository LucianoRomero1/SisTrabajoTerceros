<?php

namespace AppBundle\Service;

use AppBundle\Entity\PartidasMov;

class PartidasMovService
{
    private $partidasMovService;
    
    public function __construct($partidasMovService)
    {
        $this->partidasMovService = $partidasMovService;
    }


    public function hola(){
        return "Hola desde el servicio";
    }

}