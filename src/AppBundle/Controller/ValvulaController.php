<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\HomeService;
use AppBundle\Base\BaseController;
use AppBundle\Base\BaseService;
use AppBundle\Entity\Valvula;
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
        $this->setBreadCrumbs("Válvulas a terceros", "viewValvulas", "true");

        $tipoAccion         = $request->get('id');
        $arrayOptions       = $this->valvulaService->getTipoMovimiento($entityManager, $tipoAccion);
        $arrayTable         = $this->baseService->renderTable($entityManager, $request, "Valvula", "ValvulaFilterType", "ValvulaFilterController", "viewValvulas", $tipoAccion, $arrayOptions);
        $articulos          = $this->valvulaService->getValuesAnotherTable();
        $arrayResult        = $this->valvulaService->getAmountValvula($arrayTable[0]);

        return $this->render('valvula/view.html.twig', array(
            'valvulas'                  => $arrayTable[0],
            'pagerHtml'                 => $arrayTable[1],
            'filterForm'                => $arrayTable[2]->createView(),
            'totalOfRecordsString'      => $arrayTable[3],
            'articulos'                 => $articulos,
            'recordsValvulas'           => $arrayResult[0], //Nro de registros de valvulas
            'amountValvulas'            => $arrayResult[1], //Cantidad de válvulas
            'tipoAccion'                => $tipoAccion
        ));
    }

    /**
    * @Route("/edit/{id}", name="editValvula")
    */
    public function edit(Request $request, $id){
        $entityManager      = $this->getEm();
        $arrayData              = $this->valvulaService->getData($entityManager, $id);
    
        $form = $request->get("Valvula");
        if($form != null){
            $this->homeService->setValvula($form, $entityManager, $arrayData[0]); //array 0 es lo que retorno de la funcion getData y la pos 0 es la valvula
            $this->homeService->setPartidasMov($form, $entityManager, $arrayData[1]); //array 1 es lo que retorno de la funcion getData y la pos 1 es la partidaMov

            $this->addFlash(
                'notice',
                'Se editó correctamente el registro' 
            );
            
            return $this->redirectToRoute('viewValvulas', array('id'=>$arrayData[0]->getCaracteristica()));
        }
    
        return $this->render('valvula/edit.html.twig', array(
            'valvula'       => $arrayData[0],
            'nroRegistro'   => $arrayData[2]
        ));
    }



    /**
    * @Route("/delete/{id}", name="deleteValvula")
    */
    public function delete($id){
        $entityManager  = $this->getEm();
        $arrayData      = $this->valvulaService->getData($entityManager, $id);
        
        try{
            $entityManager->remove($arrayData[0]);
            $entityManager->remove($arrayData[1]);
            $entityManager->flush();
            // $entityManager->getConnection()->commit();

            return new JsonResponse(['success' => true]);

        }catch(\Exception $e){
            return new JsonResponse(['success' => false]);
        }
    }
}