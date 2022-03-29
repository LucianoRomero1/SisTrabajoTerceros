<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\HomeService;
use AppBundle\Base\BaseController;
use AppBundle\Base\BaseService;
use AppBundle\Entity\PartidasMov;
use AppBundle\Entity\Valvula;
use AppBundle\Entity\Articulo;
use AppBundle\Service\ValvulaService;

/**
 * @Route("/valvula")
 */
class ValvulaController extends BaseController
{
    private $homeService;
    private $baseService;
    private $valvulaService;

    public function __construct(HomeService $homeService, BaseService $baseService, ValvulaService $valvulaService){
        $this->homeService = $homeService;
        $this->baseService = $baseService;
        $this->valvulaService = $valvulaService;
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

        $tipoAccion     = $request->get('id');
        $arrayTable     = $this->baseService->renderTable($entityManager, $request, "Valvula", "ValvulaFilterType", "ValvulaFilterController", "viewValvulas", $tipoAccion);
        $articulos      = $this->valvulaService->getValuesAnotherTable();
        $amountValvulas = $this->valvulaService->getAmountValvula($arrayTable[0]);
        

        return $this->render('valvula/view.html.twig', array(
            'valvulas'                  => $arrayTable[0],
            'pagerHtml'                 => $arrayTable[1],
            'filterForm'                => $arrayTable[2]->createView(),
            'totalOfRecordsString'      => $arrayTable[3],
            'articulos'                 => $articulos,
            'amountValvulas'            => $amountValvulas,
            'tipoAccion'                => $tipoAccion
        ));
    }

    /**
    * @Route("/edit/{id}", name="editValvula")
    */
    public function edit(Request $request, $id){
        $entityManager      = $this->getEm();

        $array              = $this->valvulaService->getData($entityManager, $id);
        

        $form = $request->get("Valvula");
        if($form != null){
            $this->homeService->setValvula($form, $entityManager, $array[0]); //array 0 es lo que retorno de la funcion getData y la pos 0 es la valvula
            $this->homeService->setPartidasMov($form, $entityManager, $array[1]); //array 1 es lo que retorno de la funcion getData y la pos 1 es la partidaMov

            $this->addFlash(
                'notice',
                'Se editó correctamente el registro' 
            );
            
            return $this->redirectToRoute('viewValvulas', array('id'=>$array[0]->getCaracteristica()));
        }
    
        return $this->render('valvula/edit.html.twig', array(
            'valvula'       => $array[0],
            'nroRegistro'   => $array[2]
        ));
    }



    /**
    * @Route("/delete/{id}", name="deleteValvula")
    */
    public function delete(){

    }
}