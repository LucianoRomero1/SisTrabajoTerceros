<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\TipoMovPartidaService;
use AppBundle\Base\BaseController;

/**
 * @Route("/tipoMovPartida")
 */
class TipoMovPartidaController extends BaseController
{
     /**
     * @Route("/create", name="createTipoMovPartida")
     */
    public function create(){
        return $this->render('tipoMovPartida/create.html.twig');
    }
    
    /**
    * @Route("/view", name="viewTipoMovPartida")
    */
    public function view(){
        return $this->render('tipoMovPartida/view.html.twig');
    }

    /**
    * @Route("/edit", name="editTipoMovPartida")
    */
    public function edit(){
        return $this->render('tipoMovPartida/create.html.twig');
    }

    /**
    * @Route("/delete", name="deleteTipoMovPartida")
    */
    public function delete(){
        
    }
}