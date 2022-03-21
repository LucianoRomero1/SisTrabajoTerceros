<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\PartidasMovService;
use AppBundle\Entity\PartidasMov;
use AppBundle\Base\BaseService;
use AppBundle\Base\BaseController;

/**
 * @Route("/partidasMov")
 */
class PartidasMovController extends BaseController
{

    private $partidasMovService;
    private $baseService;

    public function __construct(PartidasMovService $partidasMovService, BaseService $baseService){
        $this->partidasMovService = $partidasMovService;
        $this->baseService = $baseService;
    }


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