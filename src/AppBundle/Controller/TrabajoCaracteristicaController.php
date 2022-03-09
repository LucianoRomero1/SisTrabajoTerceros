<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\TrabajoCaracteristicaService;
use AppBundle\Base\BaseController;

/**
 * @Route("/trabajoCaracteristica")
 */
class TrabajoCaracteristicaController extends BaseController
{
     /**
     * @Route("/create", name="createTrabajoCaracteristica")
     */
    public function create(){

    }

    
    /**
    * @Route("/view", name="viewTrabajoCaracteristica")
    */
    public function view(){

    }

    /**
    * @Route("/edit/{id}", name="editTrabajoCaracteristica")
    */
    public function edit(){

    }

    /**
    * @Route("/delete/{id}", name="deleteTrabajoCaracteristica")
    */
    public function delete(){

    }
}