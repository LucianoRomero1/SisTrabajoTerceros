<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
             
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
        
        return $this->render('default/index.html.twig');
    }

      /**
     * @Route("/example", name="example")
     */
    public function exampleAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
             
        $breadcrumbs->addRouteItem("Ejemplo", "example");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
        
        return $this->render('default/index.html.twig');
    }
}
