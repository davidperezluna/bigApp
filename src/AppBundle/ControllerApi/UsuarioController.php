<?php

namespace AppBundle\ControllerApi;

use Mapps\UsuarioBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * UsuarioController controller.
 *
 */
class UsuarioController extends FOSRestController
{
    /**
     * @Rest\Post("/usuario/logeado")
     */
    public function getLoginAction(Request $request)
    {
    	
      $data = $request->getContent();
    	$params = json_decode($data);
    	$em = $this->getDoctrine()->getManager();
      $usuario = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->username);

      return $usuario = array('usuario' =>  $usuario );
    }

    

    /**
     * @Rest\Get("/usuario/index/")
     */
    public function getIndexUserAction(Request $request)
    { 
      
      $em = $this->getDoctrine()->getManager();
      $usuarios = $em->getRepository('MappsUsuarioBundle:User')->findAll();

      $response = array(
        'status' => "success",
        'msj' => "Lista de Usuarios",
        "data" => $usuarios
    );
      return $response;
    }
}
