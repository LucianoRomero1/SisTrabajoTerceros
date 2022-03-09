<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\PartidasMovService;
use AppBundle\Base\BaseService;
use AppBundle\Base\BaseController;

/**
 * @Route("/partidasMov")
 */
class PartidasMovController extends BaseController
{
    /**
     * @Route("/create", name="createPartidasMov")
     */
    public function create(){

    }
    
    /**
    * @Route("/view", name="viewPartidasMov")
    */
    public function view(){
        
    }

    /**
    * @Route("/edit/{id}", name="editPartidasMov")
    */
    public function edit(){

    }

    /**
    * @Route("/delete/{id}", name="deletePartidasMov")
    */
    public function delete(){

    }


    
}