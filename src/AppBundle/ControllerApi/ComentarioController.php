<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\Comentario;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ComentarioController controller.
 *
 */
class ComentarioController extends FOSRestController
{
    /**
     * @Rest\Post("/comentario/publicacion/show")
     */
    public function getIndexAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $helpers = $this->get("app.helpers");
      $data = $request->getContent();
      $params = json_decode($data);
      
      $comentarios = $em->getRepository('AppBundle:Comentario')->findByPublicacion($params->publicacionId);
     
      if ($comentarios != null) {
        foreach ($comentarios as $key => $comentario) {
          $comentariosArray[$key] = array
            (
            'id' => $comentario->getId(), 
            'contenido' => $comentario->getContenido(), 
            'username' => $comentario->getUsuario()->getUsername(), 
            'imagen' => $comentario->getUsuario()->getFotoPerfil(), 
            );
        }
      }else{
        $comentariosArray = null;
      }

      return $response = array(
        'status' => "success",
        'datos' => $comentariosArray,
      );
    }

  /**
     * @Rest\Post("/comentario/publicacion/delete")
     */
    public function postEliminarComentarioAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $helpers = $this->get("app.helpers");
      $data = $request->getContent();
      $params = json_decode($data);
      
      $comentario = $em->getRepository('AppBundle:Comentario')->find($params->comentarioId);
     
      $em->remove($comentario);
      $em->flush();

      return $response = array(
        'status' => "success",
        'msj' => "comentario eliminado",
        
      );
    }
}