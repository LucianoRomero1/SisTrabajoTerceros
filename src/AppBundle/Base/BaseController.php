<?php

namespace AppBundle\Base;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends Controller
{
    public function getEm(){
        return $this->getDoctrine()->getManager();
    }

    public function setBreadCrumbs($title = null, $routeName = null){
        $breadcrumbs = $this->get("white_october_breadcrumbs");

        if($title != null && $routeName != null){
            $breadcrumbs->addRouteItem($title, $routeName);
        }
         
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
    }

    public function setBreadCrumbsWithId($title, $routeName, $id){
        $breadcrumbs = $this->get("white_october_breadcrumbs");
             
        $breadcrumbs->addItem("$title - $id", "$routeName");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
    }
}