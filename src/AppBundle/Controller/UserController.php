<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Base\BaseController;
use AppBundle\Base\BaseService;
use AppBundle\Service\UserService;
use AppBundle\Entity\Usuario;

class UserController extends BaseController
{   
    private $baseService;
    private $userService;

    public function __construct(BaseService $baseService, UserService $userService){
        $this->baseService = $baseService;
        $this->userService = $userService;
    }

    /**
     * @Route("/roles", name="roles")
     */
    public function roles()
    {
        $entityManager  = $this->getEm();
        $this->setBreadCrumbs("Roles de usuarios", "roles");
        $arrayResponse  = [];
        $arrayResponse  = $this->userService->getUsersArray($entityManager);

        return $this->render('usuarios/index.html.twig', array(
            'usuariosRol'       => $arrayResponse[0], //Users con algun rol en el sistema
            'usuariosSinRol'    => $arrayResponse[1], //Users SIN rol
        ));

    }

      /**
     * @Route("/setRole/{username}", name="setRole")
     */
    public function setRole(Request $request, $username)
    {   
        $rol            = $request->get('rol');
        $entityManager  = $this->getEm();
        $usuario        = $entityManager->getRepository(Usuario::class)->find($username);

        if(!$this->userService->switchRol($rol, $usuario, $entityManager)){
            $this->addFlash(
                'error',
                'El usuario: ' . $usuario->getUsername() . ' ya tiene asignado ese rol'
            );
        }
        else{
            $this->addFlash(
                'notice',
                'Se asignó correctamente el rol al usuario: ' . $usuario->getUsername()
            );
        }
        return $this->redirectToRoute('roles');
    }

     /**
     * @Route("/deleteRoles/{username}", name="deleteRoles")
     */
    public function deleteRoles(Request $request, $username){
        $entityManager  = $this->getEm();
        $usuario        = $entityManager->getRepository(Usuario::class)->find($username);
        
        $this->userService->deleteRoles($entityManager, $usuario);
        $this->addFlash(
            'notice',
            'Roles revocados correctamente'
        );

        return $this->redirectToRoute('roles');
        
    }
   


}
