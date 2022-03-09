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
        return $this->render('partidasMov/create.html.twig');
    }
    
    /**
    * @Route("/view", name="viewPartidasMov")
    */
    public function view(){
        return $this->render('partidasMov/view.html.twig');
    }

    /**
    * @Route("/edit/{id}", name="editPartidasMov")
    */
    public function edit(){
        return $this->render('partidasMov/create.html.twig');
    }

    /**
    * @Route("/delete/{id}", name="deletePartidasMov")
    */
    public function delete(){
        
    }


    
}