<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\PartidasMovService;
use AppBundle\Base\BaseService;
use AppBundle\Entity\PartidasMov;
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
    public function view(Request $request){
        $entityManager = $this->getEm();

        $this->setBreadCrumbs("Ver partidas movimiento", "viewPartidasMov");

        $arrayTable = $this->baseService->renderTable($entityManager, $request, "PartidasMov", "PartidasMovFilterType", "PartidasMovFilterController", "viewPartidasMov");

        return $this->render('partidasMov/view.html.twig', array(
            'partidasMov'               => $arrayTable[0],
            'pagerHtml'                 => $arrayTable[1],
            'filterForm'                => $arrayTable[2]->createView(),
            'totalOfRecordsString'      => $arrayTable[3],
        ));
        
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