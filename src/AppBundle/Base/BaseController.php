<?php

namespace AppBundle\Base;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\HttpFoundation\JsonResponse;


class BaseController extends AbstractController
{
    
    public static function getSubscribedServices()
    {
        $services = parent::getSubscribedServices();
        return array_merge($services, array(
            'white_october_breadcrumbs'         => '?'.Breadcrumbs::class,
        ));
    }
    
    public function getEm(){
        return $this->getDoctrine()->getManager();
    }

    public function setBreadCrumbs($title = null, $routeName = null, $detalle = null){
        $breadcrumbs = $this->get("white_october_breadcrumbs");

        if($title != null && $routeName != null){
            $breadcrumbs->addRouteItem($title, $routeName);
        }
        if($detalle != null){
            $breadcrumbs->prependRouteItem("Acciones", "afterHomePage");
        }
         
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
    }

    public function setBreadCrumbsWithId($title, $routeName, $id){
        $breadcrumbs = $this->get("white_october_breadcrumbs");
             
        $breadcrumbs->addItem("$title - $id", "$routeName");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
    }

     /* 
        Prepara la forma en que respondemos en todos los servicios.
        result = Respuesta json,
        error  = Error en string,
        info   = Información extra de result.
    */
    public function createResultResponse($result, $info = null){
        $response = new JsonResponse();
        $response->setData([
            "result" => $result,
            "error"  => null,
            "info"   => $info,
        ]);
        return $response;
    }

    /* 
        Prepara la forma en que respondemos en todos los servicios.
        result = Respuesta json,
        error  = Error en string,
        info   = Información extra de result.
    */
    public function createErrorResponse($error, $info = null){
        $response = new JsonResponse();
        $response->setData([
            "result" => null,
            "error"  => $error,
            "info"   => null
        ]);
        return $response;
    }

}