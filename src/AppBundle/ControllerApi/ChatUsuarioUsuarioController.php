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
      $conversaciones = $em->getRepository('AppBundle:Conversacion')->findConversacion($usuario->getId());
      
      $conversacionesArray = null;
      
      if ($conversaciones != null) {
        foreach ($conversaciones as $key => $conversacion) {
          if ($conversacion->getUsuarioUno()->getId() == $usuario->getId()) {
            $conversacionesArray[$key] = array(
              'conversacionId' => $conversacion->getId(),
              'nombre' => $conversacion->getUsuarioDos()->getNombres(),
              'foto' => $conversacion->getUsuarioDos()->getFotoPerfil(),
              'usuarioId' => $conversacion->getUsuarioDos()->getId(),
            );
          }else{
            $conversacionesArray[$key] = array(
              'conversacionId' => $conversacion->getId(),
              'nombre' => $conversacion->getUsuarioUno()->getNombres(),
              'foto' => $conversacion->getUsuarioUno()->getFotoPerfil(),
              'usuarioId' => $conversacion->getUsuarioUno()->getId(),
            );
          }
        }
      }else{
        $conversacionesArray = null;
      }
      
        // var_dump($conversaciones);
        // die();

      $response = array(
          'status' => "success",
          'msj' => "Lista de Usuarios",
          'conversaciones' => $conversacionesArray,
      );
      return $response;
    }
    
}
