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
 * ChatUsuarioUsuarioController controller.
 *
 */
class ChatUsuarioUsuarioController extends FOSRestController
{
    /**
     * @Rest\Post("/chatUsuario/usuario")
     */
    public function getChatUsuarioAction(Request $request)
    {
    	
      $data = $request->getContent();
      $params = json_decode($data);
      $em = $this->getDoctrine()->getManager();
      $usuario = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->username);
      $mensajes = $em->getRepository('AppBundle:chatUsuarioUsuario')->findByUsuario($usuario->getId());

      if ($mensajes != null) {
        foreach ($mensajes as $key => $mensaje) {
            $mensajesArray[$key] = array(
            'toUserId' => $mensaje->getDireccion()->getId(),
            'toUserName' => $mensaje->getUsuario()->getUsername(),
            );
        }
      }else{
        $mensajesArray = null;
      }
      

      $usuarioArray = array(
      'username' => $usuario->getUsername(), 
      'fotoPerfil' => $usuario->getFotoPerfil(), 
      'fotoPortada' => $usuario->getFotoPortada(), 
      'nombres' => $usuario->getNombres(), 
      'apellidos' => $usuario->getApellidos(), 
      );
      
      $response = array(
          'status' => "success",
          'msj' => "Lista de Usuarios",
          'usuario' => $usuarioArray,
          'mensajes' => $mensajesArray,
      );
      return $response;
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
