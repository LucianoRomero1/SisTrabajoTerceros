<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\ValvulaService;
use AppBundle\Entity\Valvula;
use AppBundle\Base\BaseController;

/**
 * @Route("/valvula")
 */
class ValvulaController extends BaseController
{
    /**
    * @Route("/create", name="createValvula")
    */
    public function create(){
        return $this->render('valvula/create.html.twig');
    }

    /**
    * @Route("/view", name="viewValvulas")
    */
    public function view(){
        return $this->render('valvula/view.html.twig');
    }

    /**
    * @Route("/edit/{id}", name="editValvula")
    */
    public function edit(){
        return $this->render('valvula/create.html.twig');
    }

    /**
    * @Route("/delete/{id}", name="deleteValvula")
    */
    public function delete(){

    }
}