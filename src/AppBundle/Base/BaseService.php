<?php

namespace AppBundle\Base;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;

class BaseService extends AbstractController
{


    /**
    * Create filter form and process filter request.
    *
    */
    public function filter($queryBuilder, Request $request, $formName, $controllerFilter){
        $session = $request->getSession();
        $filterForm = $this->createForm("AppBundle\Form\\$formName");

        //Reset filter
        if($request->get('filter_action') == 'reset'){
            if($session->get($controllerFilter) != null){
                //If null apply reset, is necessary because without the validate, this closed the session
                $session->remove($controllerFilter);
            }
        }

        //Filter action
        if($request->get('filter_action') == 'filter'){
            $filterForm->handleRequest($request);
            
            // Bind values from the request
            if($filterForm->isValid()){
                // Build the query from the given form object
                $this->filter->addFilterConditions($filterForm, $queryBuilder);

                //Save filter to session
                $filterData = $filterForm->getData();
                $session->set($controllerFilter, $filterData);
            }
        }
        return array($filterForm, $queryBuilder);

    }

     /**
    * Get results from paginator and get paginator view.
    *
    */
    public function paginator($queryBuilder, Request $request, $routeName){
      
        //Sorting
        $sortCol = $queryBuilder->getRootAlias().'.'.$request->get('pcg_sort_col', 'id');
        $queryBuilder->orderBy($sortCol, $request->get('pcg_sort_order', 'DESC'));

        //Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($request->get('pcg_show' , 10));

        try {
            $pagerfanta->setCurrentPage($request->get('pcg_page', 1));
        } catch (\Pagerfanta\Exception\OutOfRangeCurrentPageException $ex) {
            $pagerfanta->setCurrentPage(1);
        }

        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me, $request)
        {
            $requestParams = $request->query->all();
            $requestParams['pcg_page'] = $page;
            return $me->generateUrl($routeName, $requestParams);
        };

        // Paginator - view
        $view = new TwitterBootstrap4View();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => '<<',
            'next_message' => '>>',
        ));

        return array($entities, $pagerHtml);

    }

     
    /*
     * Calculates the total of records string
     */
    public function getTotalOfRecordsString($queryBuilder, $request) {
        $totalOfRecords = $queryBuilder->select('COUNT(e.id)')->getQuery()->getSingleScalarResult();
        $show = $request->get('pcg_show', 10);
        $page = $request->get('pcg_page', 1);

        $startRecord = ($show * ($page - 1)) + 1;
        $endRecord = $show * $page;

        if ($endRecord > $totalOfRecords) {
            $endRecord = $totalOfRecords;
        }
        return "Mostrando $startRecord - $endRecord de $totalOfRecords reg.";
    }

}