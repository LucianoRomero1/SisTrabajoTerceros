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

    }
    
    /**
    * @Route("/view", name="viewTipoMovPartida")
    */
    public function view(){

    }

    /**
    * @Route("/edit", name="editTipoMovPartida")
    */
    public function edit(){

    }

    /**
    * @Route("/delete", name="deleteTipoMovPartida")
    */
    public function delete(){

    }
}