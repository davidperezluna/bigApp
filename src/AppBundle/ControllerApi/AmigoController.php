<?php

namespace AppBundle\ControllerApi;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AmigoController controller.
 *
 */
class AmigoController extends FOSRestController
{

    /**
     * @Rest\Get("amigo/user/pag")
     */
    public function postUsuariosAction()
    { 
        
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   =    "SELECT u 
                    FROM MappsUsuarioBundle:User u";

        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            1/*page number*/,
            20/*limit per page*/
        );

        $usuarios = $query->getResult();

        foreach ($usuarios as $key => $usuario) {
            $userArray[$key] = array(
                'id'=> $usuario->getId(),
                'username' => $usuario->getUsername(), 
                'fotoPerfil' => $usuario->getFotoPerfil(), 
                'fotoPortada' => $usuario->getFotoPortada(), 
                'nombres' => $usuario->getNombres(), 
                'apellidos' => $usuario->getApellidos(), 
    
            );
        }

        return $response = array(
            'status' => "success",
            'usuarios' => $userArray,
        );
    }

     /**
     * @Rest\Post("amigo/find/user")
     */
    public function postBuscarAmigoAction(Request $request)
    { 
        
        $em = $this->getDoctrine()->getManager();
        $data = $request->getContent();
        $params = json_decode($data);

        $stringBusqueda = $params->stringBusqueda;
       

        $usuarios = $em->getRepository('AppBundle:Amigo')->findAmigoLike($stringBusqueda);
        $userArray = null;

        if ($usuarios) {
            foreach ($usuarios as $key => $usuario) {
                $userArray[$key] = array( 
                    'id'=> $usuario->getId(),
                    'username' => $usuario->getUsername(), 
                    'fotoPerfil' => $usuario->getFotoPerfil(), 
                    'fotoPortada' => $usuario->getFotoPortada(), 
                    'nombres' => $usuario->getNombres(), 
                    'apellidos' => $usuario->getApellidos(), 
        
                );
            }
        }

        return $response = array(
            'status' => "success",
            'usuarios' => $userArray,
        );
    }

}