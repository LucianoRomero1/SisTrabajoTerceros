<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Base\BaseController;
use AppBundle\Base\BaseService;
use AppBundle\Entity\Articulo;
use AppBundle\Entity\DesvioPartidas;
use AppBundle\Service\HomeService;
use AppBundle\Entity\Valvula;
use AppBundle\Entity\PartidasCobol;


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
    public function indexAction(){
        $this->setBreadCrumbs();
        $entityManager      = $this->getEm();
        $stock              = $this->homeService->getStockPara($entityManager);
        $periodo            = $this->homeService->getPeriodoActual();

        return $this->render('home/homePage.html.twig', array(
            "mes"   => $periodo[0], //Mes
            "anio"  => $periodo[1], //Año
            "stock" => $stock
        ));
    }

    /**
     * @Route("/afterHomePage", name="afterHomePage")
     */
    public function afterHomePage(Request $request)
    {
        $this->setBreadCrumbs("Acciones", "afterHomePage");
        $entityManager      = $this->getEm();
        $caracteristicas    = $this->homeService->getCaracteristicas($entityManager);
        $nroRegistro        = $entityManager->getRepository(Valvula::class)->getCountValvulas($entityManager);
        $userSesion         = $this->getUser();
        $rolesUser          = $userSesion->getRoles();
        $arrayRoles         = $this->homeService->getArrayRoles($rolesUser);
        $idFromHomepage     = $request->query->get("id");
        $idHomePage         = $request->query->get("idHome");

        return $this->render('home/index.html.twig', array(
            'caracteristicas'       => $caracteristicas,
            'nroRegistro'           => $nroRegistro,
            'rolesUser'             => $arrayRoles,
            'user'                  => $userSesion,
            'idFromHomePage'        => $idFromHomepage,
            'idHomePage'            => $idHomePage
        ));
    }

     /**
     * @Route("/envioTercero", name="envioTercero")
     */
    public function envioTercero(Request $request){
        $entityManager      = $this->getEm();
        $form               = $request->get("Valvula");
        $idFromHomepage     = $request->query->get("idFromHomePage");

        if(is_null($idFromHomepage)){
            $idFromHomepage     = $request->query->get("idHomePage");
        }

        if($form != null){
            
            $this->homeService->setValvula($form, $entityManager);
            $this->homeService->setPartidasMov($form, $entityManager);
            $this->homeService->envioEmail($form, $entityManager);
            
            $this->addFlash(
                'notice',
                'Envío realizado'
            );

            return $this->redirectToRoute("afterHomePage", array("idHome"=>$idFromHomepage));
        }

    }


    /**
     * @Route("/recepcionEnTercero", name="recepcionEnTercero")
     */
    public function recepcionEnTercero(Request $request){
        $entityManager      = $this->getEm();
        $form = $request->get("Valvula");
        $idFromHomepage     = $request->query->get("idFromHomePage");

        if(is_null($idFromHomepage)){
            $idFromHomepage     = $request->query->get("idHomePage");
        }

        if($form != null){
            $this->homeService->setValvula($form, $entityManager);
            $this->homeService->setPartidasMov($form, $entityManager);

            $this->addFlash(
                'notice',
                'Recepción realizada'
            );

            return $this->redirectToRoute("afterHomePage", array("idHome"=>$idFromHomepage));
        }

    }

      /**
     * @Route("/recepcionDeTercero", name="recepcionDeTercero")
     */
    public function recepcionDeTercero(Request $request){
        $entityManager      = $this->getEm();
        $form = $request->get("Valvula");
        $idFromHomepage     = $request->query->get("idFromHomePage");

        if(is_null($idFromHomepage)){
            $idFromHomepage     = $request->query->get("idHomePage");
        }

        if($form != null){
            $this->homeService->setValvula($form, $entityManager);
            $this->homeService->setPartidasMov($form, $entityManager);

            $this->addFlash(
                'notice',
                'Reingreso realizado'
            );

            return $this->redirectToRoute("afterHomePage", array("idHome"=>$idFromHomepage));
        }
    }

 
      /**
     * @Route("/devolucionTercero", name="devolucionTercero")
     */
    public function devolucionTercero(Request $request){
        $entityManager      = $this->getEm();
        $form = $request->get("Valvula");
        $idFromHomepage     = $request->query->get("idFromHomePage");
        
        if(is_null($idFromHomepage)){
            $idFromHomepage     = $request->query->get("idHomePage");
        }

        if($form != null){
            $this->homeService->setValvula($form, $entityManager);
            $this->homeService->setPartidasMov($form, $entityManager);
            $this->homeService->envioEmail($form, $entityManager);

            $this->addFlash(
                'notice',
                'Devolución realizada'
            );

            return $this->redirectToRoute("afterHomePage", array("idHome"=>$idFromHomepage));
        }
    }

    /**
     * @Route("/produccionTercero", name="produccionTercero")
     */
    public function produccionTercero(Request $request){

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
            'caracteristica'            => $caracteristica
        ));
    }

    /**
     * @Route("/ajaxDeposito", name="ajaxDeposito")
     * @Method({"POST"})
     */
    public function ajaxDeposito(){
        $entityManager      = $this->getEm();
        $codDeposito        = $_REQUEST['codDeposito'];
        $depo               = $entityManager->getRepository(Valvula::class)->findOneBy(array("codDeposito"=>$codDeposito));
    
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
    public function ajaxProveedor(){
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
    public function ajaxValvula(){
        $entityManager      = $this->getEm();
        $codDesvio          = $_REQUEST["codDesvio"];
        $nroPartida         = $_REQUEST["nroPartida"];
        $tipo               = $_REQUEST["tipo"];
        $caracteristica     = $_REQUEST["caracteristica"];
        $retrabajar         = $_REQUEST["retrabajar"];    
        $arrayInfo          = [];

        //Esto es la cantidad inicial que se solicitó 
        $cantidadInicial    = $this->homeService->getCantidadInicial($entityManager, $codDesvio, $nroPartida);

        //Esto es para la cantidad a mostrar de la valvula, lo tengo que hacer primero porque va de la mano con el result response correcto
        $cantidadAMostrar   = $this->homeService->getCantidad($tipo, $caracteristica, $nroPartida, $codDesvio, $entityManager);
        if($cantidadAMostrar <= 0 && $retrabajar == "false"){
            return $this->createErrorResponse("No hay piezas disponibles para realizar el movimiento", "");
        }

        //Esto es para traer la descripcion de la valvula
        $codArticulo        = $entityManager->getRepository(DesvioPartidas::class)->findOneBy(array('codDesvio'=>$codDesvio, 'nroPartida'=>$nroPartida));
        if(is_null($codArticulo)){
            return $this->createErrorResponse("La válvula solicitada no existe", "");
        }

        $descripcionValvula = $entityManager->getRepository(Articulo::class)->findOneBy(array("id"=>$codArticulo->getCodArticulo()))->getDescripcion();

        //Esto es para ver si hay que chequear sin terminado punta o no
        $sinTerminadoPunta  = 0;
        if($caracteristica == "Nitrurar"){
            $sinTerminadoPunta = $this->homeService->sinTerminadoPunta($entityManager, $codArticulo->getCodArticulo());
            $sinTerminadoPunta = $sinTerminadoPunta[0]["VALOR"];
        }

        if(is_null($descripcionValvula)){
            return $this->createErrorResponse("La válvula solicitada no existe", "");
        }
        else{
            $descripcion        = $descripcionValvula;
            array_push($arrayInfo, $descripcion, $cantidadAMostrar, $cantidadInicial[0]["CANTIDAD"], $sinTerminadoPunta);  
            return $this->createResultResponse("OK", $arrayInfo);
        }       
    }

  

}
