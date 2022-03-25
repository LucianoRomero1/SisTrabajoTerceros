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
        $this->setBreadCrumbs();
        $entityManager      = $this->getEm();

        $usuarios = $entityManager->getRepository(Usuario::class)->findAll();

        // foreach($usuarios as $user){
        //     dump($user->getRoles());
        // }
        
        // die;

        return $this->render('usuarios/roles.html.twig', array(
            'usuarios'  => $usuarios
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

        $usuario = $this->userService->switchRol($rol, $usuario, $entityManager);

        return $this->redirectToRoute('roles');
    }

}
