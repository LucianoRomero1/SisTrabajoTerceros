<?php

namespace AppBundle\Service;

use AppBundle\Base\BaseService;
use GuardBundle\Entity\Role;
use AppBundle\Entity\Usuario;

class UserService extends BaseService
{
    private $baseService;

    public function __construct(BaseService $baseService){
        $this->baseService = $baseService;
    }

    public function switchRol($rol, $usuario, $entityManager){
        $rol_i = $entityManager->getRepository(Role::class)->find($rol);
        if($rol == "ROLE_ADMIN_SIS"){
            $arrayRoles = $this->setRoleAdmin($entityManager);
            for($i = 0; $i < count($arrayRoles); $i++){
                $usuario->addRole($arrayRoles[$i]);
            }
            $entityManager->persist($usuario);
            $entityManager->flush();
            return true;
        }
        else{
            foreach($usuario->getRoles() as $rol){
                if($rol == $rol_i){
                    return false;
                }
            }            
            $usuario->addRole($rol_i);
            $entityManager->persist($usuario);
            $entityManager->flush();
    
            return true;
        }
    }

    public function setRoleAdmin($entityManager){
        $role_e = $entityManager->getRepository(Role::class)->findOneBy(array("role"=>"ROLE_ENVIO_3°"));
        $role_r = $entityManager->getRepository(Role::class)->findOneBy(array("role"=>"ROLE_RECEPCION_3°"));
        $role_d = $entityManager->getRepository(Role::class)->findOneBy(array("role"=>"ROLE_DEVOLUCION_3°"));
        $role_o = $entityManager->getRepository(Role::class)->findOneBy(array("role"=>"ROLE_REINGRESO_3°"));
        $role_a = $entityManager->getRepository(Role::class)->findOneBy(array("role"=>"ROLE_ADMIN_SIS"));

        $arrayRoles = array(
            "0" => $role_e,
            "1" => $role_r,
            "2" => $role_d,
            "3" => $role_o,
            "4" => $role_a
        );

        return $arrayRoles;
    }

    public function deleteRoles($entityManager, $usuario){
        $role_e = $entityManager->getRepository(Role::class)->findOneBy(array("role"=>"ROLE_ENVIO_3°"));
        $role_r = $entityManager->getRepository(Role::class)->findOneBy(array("role"=>"ROLE_RECEPCION_3°"));
        $role_d = $entityManager->getRepository(Role::class)->findOneBy(array("role"=>"ROLE_DEVOLUCION_3°"));
        $role_o = $entityManager->getRepository(Role::class)->findOneBy(array("role"=>"ROLE_REINGRESO_3°"));
        $role_a = $entityManager->getRepository(Role::class)->findOneBy(array("role"=>"ROLE_ADMIN_SIS"));

        $usuario->removeRole($role_e);
        $usuario->removeRole($role_r);
        $usuario->removeRole($role_d);
        $usuario->removeRole($role_o);
        $usuario->removeRole($role_a);

        $entityManager->persist($usuario);
        $entityManager->flush();

        return true;
    }


    public function getUsersArray($entityManager){
        $arrayUserRol       = []; //En este array voy a poner los usuarios con roles del sistema y NO mostrar los otros roles que tengan
        $arraySinRol        = []; //En este array voy a agregar los usuarios que NO tengan roles del sistema
        $arrayReturn        = [];

        $usuarios = $entityManager->getRepository(Usuario::class)->findAll();

        foreach($usuarios as $user){
            if($user->getRoles() == []){
                array_push($arraySinRol, $user);
            }
            foreach($user->getRoles() as $rol){
                //Asigno al array solo los roles de mi sistema, los demas no me interesan
                if($rol->getRole() == "ROLE_ADMIN" || $rol->getRole() == "ROLE_ADMIN_SIS" || $rol->getRole() == "ROLE_USER" || $rol->getRole() == "ROLE_ENVIO_3°" || $rol->getRole() == "ROLE_REINGRESO_3°" || $rol->getRole() == "ROLE_RECEPCION_3°" ||  $rol->getRole() == "ROLE_DEVOLUCION_3°" ||  $rol->getRole() == "ROLE_CONSULTA"){  
                    array_push($arrayUserRol, $user);
                }
                else{          
                    array_push($arraySinRol, $user);
                }
            }
                       
        }

        //Array unique elimina valores repetidos y array values los indexa nuevamente bien
        $arraySinRol    = array_unique($arraySinRol);
        $arrayUserRol   = array_unique($arrayUserRol);
        $arraySinRol    = array_values($arraySinRol);
        $arrayUserRol   = array_values($arrayUserRol);

        for($i = 0; $i < count($arraySinRol); $i++){
            if(in_array($arraySinRol[$i]->getUsername(), $arrayUserRol)){
                unset($arraySinRol[$i]);
                
            }
        }

        array_push($arrayReturn, $arrayUserRol, $arraySinRol);

        return $arrayReturn;

    }

}