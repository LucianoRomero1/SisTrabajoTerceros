<?php

namespace AppBundle\Base;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;


class BaseController extends AbstractController
{
    private $filter;

    public function __construct(FilterBuilderUpdaterInterface $filter)
    {
        $this->filter = $filter;
    }


    public static function getSubscribedServices()
    {
        $services = parent::getSubscribedServices();
        return array_merge($services, array(
            'white_october_breadcrumbs' => '?'.Breadcrumbs::class,
        ));
    }
    
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