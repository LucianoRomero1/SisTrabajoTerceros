<?php

namespace AppBundle\Service;

use AppBundle\Base\BaseService;
use GuardBundle\Entity\Role;

class UserService extends BaseService
{
    private $baseService;

    public function __construct(BaseService $baseService){
        $this->baseService = $baseService;
    }

    public function switchRol($rol, $usuario, $entityManager){

        $rol_i = $entityManager->getRepository(Role::class)->find($rol);
        $usuario->addRole($rol_i);

        $entityManager->persist($usuario);
        $entityManager->flush();

        return $usuario;
    }

}