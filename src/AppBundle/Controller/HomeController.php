<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Base\BaseController;
use AppBundle\Base\BaseService;
use AppBundle\Entity\PartidasMov;
use AppBundle\Service\HomeService;
use AppBundle\Repository\ValvulaRepository;
use AppBundle\Entity\Valvula;



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
    public function indexAction()
    {
        $this->setBreadCrumbs();
        $entityManager      = $this->getEm();
        $caracteristicas    = $this->homeService->getCaracteristicas($entityManager);
        $nroRegistro        = $entityManager->getRepository(Valvula::class)->getCountValvulas($entityManager);
        //$arrayCaracteristicas = $this->homeService->getArrayCaracteristicas();
        
        return $this->render('home/index.html.twig', array(
            'caracteristicas'       => $caracteristicas,
            'nroRegistro'           => $nroRegistro
        ));
    }

     /**
     * @Route("/envioTercero", name="envioTercero")
     */
    public function envioTercero(Request $request){
        $entityManager      = $this->getEm();
        $form = $request->get("Valvula");
        if($form != null){
            $this->homeService->setPartidasMov($form, $entityManager);
            
            
            //$entityManager->persist($valvula);
            //$entityManager->persist($partidaMov);
            $entityManager->flush();
        }
        dump("envioTercero");
        die;
    }


    /**
     * @Route("/recepcionEnTercero", name="recepcionEnTercero")
     */
    public function recepcionEnTercero(Request $request){
        $entityManager      = $this->getEm();
        $formArea = $request->get("Valvula");
        dump("recepcionEnTercero");
        die;
    }

      /**
     * @Route("/recepcionDeTercero", name="recepcionDeTercero")
     */
    public function recepcionDeTercero(Request $request){
        $entityManager      = $this->getEm();
        $formArea = $request->get("Valvula");
        dump("recepcionDeTercero");
        die;
    }

 
      /**
     * @Route("/devolucionTercero", name="devolucionTercero")
     */
    public function devolucionTercero(Request $request){
        $entityManager      = $this->getEm();
        $formArea = $request->get("Valvula");
        dump("devolucionTercero");
        die;
    }

         /**
     * @Route("/produccionTercero", name="produccionTercero")
     */
    public function produccionTercero(Request $request){
        $formArea = $request->get("Valvula");
        dump("produccionTercero");
        die;
    }

      /**
     * @Route("/controlStock", name="controlStock")
     * 
    */
    public function controlStock(Request $request){ 
        $entityManager = $this->getEm();
        $this->setBreadCrumbs("Movimientos válvulas", "controlStock");
        
        
        $caracteristica = $request->get('caracteristica');
        $arrayTable     = $this->baseService->renderTable($entityManager, $request, "Valvula", "StockFilterType", "StockFilterController", "controlStock");
        $results        = $this->homeService->getStock($entityManager, $caracteristica);

        return $this->render('controlStock/index.html.twig', array(
            'valvulas'                  => $results,
            'pagerHtml'                 => $arrayTable[1],
            'filterForm'                => $arrayTable[2]->createView(),
            'totalOfRecordsString'      => $arrayTable[3],
        ));
    }

    /**
     * @Route("/ajaxDeposito", name="ajaxDeposito")
     * @Method({"POST"})
     */
    public function ajaxDeposito(Request $request){
        $entityManager      = $this->getEm();
        $codDeposito        = $_REQUEST['codDeposito'];
        
        $depo               =  $entityManager->getRepository(Valvula::class)->findOneBy(array("codDeposito"=>$codDeposito));
    
        if(is_null($depo)){
            return $this->createErrorResponse("El depósito solicitado no existe", "");
        }
        else{
            $descripcionDepo    = $depo->getCodDeposito()->getDescripcion();
            return $this->createResultResponse("OK", $descripcionDepo);
        }
    }

      /**
     * @Route("/ajaxProveedor", name="ajaxProveedor")
     * @Method({"POST"})
     */
    public function ajaxProveedor(Request $request){
        $entityManager      = $this->getEm();
        $codProveedor       = $_REQUEST['codProveedor'];
        
        $proveedor          =  $entityManager->getRepository(Valvula::class)->findOneBy(array("codProveedor"=>$codProveedor));
    
        if(is_null($proveedor)){
            return $this->createErrorResponse("El proveedor solicitado no existe", "");
        }
        else{
            $descripcionProveedor    = $proveedor->getCodProveedor()->getDescripcion();
            return $this->createResultResponse("OK", $descripcionProveedor);
        }
    }

     /**
     * @Route("/ajaxValvula", name="ajaxValvula")
     * @Method({"POST"})
     */
    public function ajaxValvula(Request $request){
        $entityManager      = $this->getEm();
        $codDesvio          = $_REQUEST["codDesvio"];
        $nroPartida         = $_REQUEST["nroPartida"];

        $valvula            = $entityManager->getRepository(Valvula::class)->findOneBy(array("codDesvio"=>$codDesvio, "nroPartida"=>$nroPartida));
        if(is_null($valvula)){
            return $this->createErrorResponse("La válvula solicitada no existe", "");
        }
        else{
            $descripcion        = $valvula->getCodArticulo()->getDescripcion();
            return $this->createResultResponse("OK", $descripcion);
        }       
    }


}
