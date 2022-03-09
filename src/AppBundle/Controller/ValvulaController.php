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

    }

    /**
    * @Route("/view", name="viewValvulas")
    */
    public function view(){

    }

    /**
    * @Route("/edit/{id}", name="editValvula")
    */
    public function edit(){

    }

    /**
    * @Route("/delete/{id}", name="deleteValvula")
    */
    public function delete(){

    }
}