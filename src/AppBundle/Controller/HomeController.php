<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Base\BaseController;
use AppBundle\Base\BaseService;
use AppBundle\Service\HomeService;

class HomeController extends BaseController
{   

    private $homeService;
    private $baseService;

    public function __construct(HomeService $homeService, BaseService $baseService){
        $this->homeService = $homeService;
        $this->baseService = $baseService;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $this->setBreadCrumbs();
        $em = $this->getEm();
        $caracteristicas = $this->homeService->getCaracteristicas($em);
        
        return $this->render('home/index.html.twig', array(
            'caracteristicas'   => $caracteristicas
        ));
    }

     /**
     * @Route("/envioTercero", name="envioTercero")
     */
    public function envioTercero(){
        dump("envioTercero");
        die;
    }

    /**
     * @Route("/recepcionEnTercero", name="recepcionEnTercero")
     */
    public function recepcionEnTercero(){
        dump("recepcionEnTercero");
        die;
    }

      /**
     * @Route("/recepcionDeTercero", name="recepcionDeTercero")
     */
    public function recepcionDeTercero(){
        dump("recepcionDeTercero");
        die;
    }

      /**
     * @Route("/produccionTercero", name="produccionTercero")
     */
    public function produccionTercero(){
        dump("produccionTercero");
        die;
    }

      /**
     * @Route("/devolucionTercero", name="devolucionTercero")
     */
    public function devolucionTercero(){
        dump("devolucionTercero");
        die;
    }

        /**
     * @Route("/controlStock", name="controlStock")
     */
    public function controlStock(Request $request){ 
        $entityManager = $this->getEm();
        $this->setBreadCrumbs("Movimientos válvulas", "controlStock");

        $arrayTable = $this->baseService->renderTable($entityManager, $request, "Valvula", "StockFilterType", "StockFilterController", "controlStock");

        return $this->render('controlStock/index.html.twig', array(
            'valvulas'                  => $arrayTable[0],
            'pagerHtml'                 => $arrayTable[1],
            'filterForm'                => $arrayTable[2]->createView(),
            'totalOfRecordsString'      => $arrayTable[3],
        ));
    }


}
