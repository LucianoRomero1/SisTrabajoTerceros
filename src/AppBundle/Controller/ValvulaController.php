<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\ValvulaService;
use AppBundle\Base\BaseController;
use AppBundle\Base\BaseService;


/**
 * @Route("/valvula")
 */
class ValvulaController extends BaseController
{
    private $valvulaService;
    private $baseService;

    public function __construct(ValvulaService $valvulaService, BaseService $baseService){
        $this->valvulaService = $valvulaService;
        $this->baseService = $baseService;
    }
    
    /**
    * @Route("/create", name="createValvula")
    */
    public function create(){
        return $this->render('valvula/create.html.twig');
    }

    /**
    * @Route("/view", name="viewValvulas")
    */
    public function view(Request $request){
        $entityManager = $this->getEm();
        $this->setBreadCrumbs("Válvulas a terceros", "viewValvulas");

        $arrayTable     = $this->baseService->renderTable($entityManager, $request, "Valvula", "ValvulaFilterType", "ValvulaFilterController", "viewValvulas");
        $articulos      = $this->valvulaService->getValuesAnotherTable();
        $amountValvulas = $this->valvulaService->getAmountValvula($arrayTable[0]);
        

        return $this->render('valvula/view.html.twig', array(
            'valvulas'                  => $arrayTable[0],
            'pagerHtml'                 => $arrayTable[1],
            'filterForm'                => $arrayTable[2]->createView(),
            'totalOfRecordsString'      => $arrayTable[3],
            'articulos'                 => $articulos,
            'amountValvulas'            => $amountValvulas
        ));
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