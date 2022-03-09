<?php

namespace AppBundle\Service;

use AppBundle\Entity\PartidasMov;
use AppBundle\Base\BaseService;


class PartidasMovService extends BaseService
{   
    private $baseService;

    public function __construct(BaseService $baseService){
        $this->baseService = $baseService;
    }


    public function renderTable($entityManager, $request){
        $queryBuilder = $entityManager->getRepository(PartidasMov::class)->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->baseService->filter($queryBuilder, $request, "PartidasMovFilterType", "PartidasMovControllerFilter");
        list($partidasMov, $pagerHtml) = $this->baseService->paginator($queryBuilder, $request, "viewPartidasMov");

        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return array($partidasMov, $pagerHtml, $filterForm,  $totalOfRecordsString);
    }
  

}