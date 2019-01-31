<?php

namespace AppBundle\ControllerApi;

use Mapps\UsuarioBundle\Entity\User;
use AppBundle\Entity\ChatUsuarioUsuario;
use AppBundle\Entity\Conversacion;
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
              'username' => $conversacion->getUsuarioDos()->getUsername(),
              'usuarioId' => $conversacion->getUsuarioDos()->getId(),
              'oneSignalId' => $conversacion->getUsuarioDos()->getPlayerId(),
            );
          }else{
            $conversacionesArray[$key] = array(
              'conversacionId' => $conversacion->getId(),
              'nombre' => $conversacion->getUsuarioUno()->getNombres(),
              'username' => $conversacion->getUsuarioUno()->getUsername(),
              'foto' => $conversacion->getUsuarioUno()->getFotoPerfil(),
              'usuarioId' => $conversacion->getUsuarioUno()->getId(),
              'oneSignalId' => $conversacion->getUsuarioUno()->getPlayerId(),
            );
          }
        }
      }else{
        $conversacionesArray = null;
      }

      $response = array(
          'status' => "success",
          'msj' => "Lista de Usuarios",
          'conversaciones' => $conversacionesArray,
      );
      return $response;
    }

    /**
     * @Rest\Post("/chatUsuario/chats")
     */
    public function getChatAction(Request $request)
    {
    	
      $data = $request->getContent();
      $params = json_decode($data);
      $em = $this->getDoctrine()->getManager();
      // var_dump($params);
      //   die();
      $chats = $em->getRepository('AppBundle:ChatUsuarioUsuario')->findByConversacion($params->conversacionId);

      
      $chatsArray = null;
      
      if ($chats != null) {
        foreach ($chats as $key => $chat) {
          $chatsArray[$key] = array(
              'mensaje' => $chat->getMensaje(),
              'toUserNames' => $chat->getDireccion()->getNombres(),
              'toUserFoto' => $chat->getDireccion()->getFotoPerfil(),
              'myUserNames' => $chat->getUsuario()->getNombres(),
              'myUserFoto' => $chat->getUsuario()->getFotoPerfil(),
              'myUser' => $chat->getUsuario()->getUsername(),
              'toUser' => $chat->getDireccion()->getUsername(),
              'status'=> 'success'
            );
        }
      }else{
        $chatsArray = null;
      }
      
        

      $response = array(
          'status' => "success",
          'msj' => "Lista de Usuarios",
          'chats' => $chatsArray,
      );
      return $response;
    }

    /**
     * @Rest\Post("/chatUsuario/new")
     */
    public function newChatAction(Request $request)
    {
    	
      $data = $request->getContent();
      $params = json_decode($data);
      $em = $this->getDoctrine()->getManager();

      $usuarioEmisor = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->toUser);
      $usuarioReceptor = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->myUser);

      $conversaciones = $em->getRepository('AppBundle:Conversacion')->findOneBy(
        array(
        'usuarioUno' => $usuarioEmisor->getId(),
        'usuarioDos' => $usuarioReceptor->getId(),
        )
      );

      $conversaciones2 = $em->getRepository('AppBundle:Conversacion')->findOneBy(
        array(
        'usuarioUno' => $usuarioReceptor->getId(),
        'usuarioDos' => $usuarioEmisor->getId(),
        )
      );

      $conversacion = null;
      if ($conversaciones) {
        $conversacion = $conversaciones;
      } 
      if ($conversaciones2) {
        $conversacion = $conversaciones2;
      } 
      if ($conversacion) {
        $chat = new ChatUsuarioUsuario();
        $date = new \DateTime('now');

        $chat->setUsuario($usuarioReceptor);
        $chat->setDireccion($usuarioEmisor);
        $chat->setCreatedAt($date);
        $chat->setMensaje($params->mensaje);
        $chat->setVisto(0);
        $chat->setConversacion($conversacion);
      
        $em->persist($chat);
        $em->flush();
        
      }else {
       $conversacion = new Conversacion();

       $conversacion->setUsuarioUno($usuarioReceptor);
       $conversacion->setUsuarioDos($usuarioEmisor);

       $em->persist($conversacion);
       $em->flush();

       $chat = new ChatUsuarioUsuario();
        $date = new \DateTime('now');

        $chat->setUsuario($usuarioReceptor);
        $chat->setDireccion($usuarioEmisor);
        $chat->setCreatedAt($date);
        $chat->setMensaje($params->mensaje);
        $chat->setVisto(0);
        $chat->setConversacion($conversacion);
      
        $em->persist($chat);
        $em->flush();
      }

      // die();

      
      $response = array(
          'status' => "success",
          'msj' => "ok",
      );
      return $response;
    }
    
}
