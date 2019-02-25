<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\SubastaComentario;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ComentarioSubastaController controller.
 *
 */
class ComentarioSubastaController extends FOSRestController
{
    /**
     * @Rest\Post("/comentarioSubasta/subasta/show")
     */
    public function getIndexAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $helpers = $this->get("app.helpers");
      $data = $request->getContent();
      $params = json_decode($data);
      
      $comentarioSubastas = $em->getRepository('AppBundle:SubastaComentario')->findBy(
        array('subasta' => $params->subastaId)
      );
     
      if ($comentarioSubastas != null) {
        foreach ($comentarioSubastas as $key => $comentarioSubasta) {
          $comentarioSubastasArray[$key] = array
            (
            'id' => $comentarioSubasta->getId(), 
            'contenido' => $comentarioSubasta->getContenido(),  
            'username' => $comentarioSubasta->getUsuarioEmisor()->getUsername(), 
            'imagen' => $comentarioSubasta->getUsuarioEmisor()->getFotoPerfil(), 
            );
        }
      }else{
        $comentarioSubastasArray = null;
      }

      return $response = array(
        'status' => "success",
        'datos' => $comentarioSubastasArray,
      );
    }

  /**
     * @Rest\Post("/comentarioSubasta/subasta/delete")
     */
    public function postEliminarComentarioAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $helpers = $this->get("app.helpers");
      $data = $request->getContent();
      $params = json_decode($data);
      
      $comentarioSubasta = $em->getRepository('AppBundle:Comentario')->find($params->comentarioSubastaId);
     
      $em->remove($comentarioSubasta);
      $em->flush();

      return $response = array(
        'status' => "success",
        'msj' => "comentarioSubasta eliminado",
        
      );
    }

  /**
     * @Rest\Post("/comentarioSubasta/new")
     */
    public function postCrearComentarioAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $data = $request->getContent();
      $params = json_decode($data);
      $fechaHoy = new \DateTime("now");
      
      $comentarioSubasta = new SubastaComentario();
      $fechaHoy = new \DateTime("now");
      $usuario = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->usuario);
      $subasta = $em->getRepository('AppBundle:Subasta')->find($params->subastaId);


      $comentarioSubasta->setSubasta($subasta);
      $comentarioSubasta->setUsuarioEmisor($usuario);
      $comentarioSubasta->setContenido($params->contenido);
      $comentarioSubasta->setFecha($fechaHoy);
     
      $em->persist($comentarioSubasta);
      $em->flush(); 

      return $response = array(
        'status' => "success",
        'msj' => "comentarioSubasta Creado",
        
      );
    }
}