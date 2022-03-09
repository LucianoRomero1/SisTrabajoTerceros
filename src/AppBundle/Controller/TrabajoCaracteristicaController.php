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
        return $this->render('trabajoCaracteristica/create.html.twig');
    }

    /**
    * @Route("/view", name="viewTrabajoCaracteristica")
    */
    public function view(){
        return $this->render('trabajoCaracteristica/view.html.twig');
    }

    /**
    * @Route("/edit/{id}", name="editTrabajoCaracteristica")
    */
    public function edit(){
        return $this->render('trabajoCaracteristica/create.html.twig');
    }

    /**
    * @Route("/delete/{id}", name="deleteTrabajoCaracteristica")
    */
    public function delete(){

    }
}