<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\Categoria;
use AppBundle\Entity\SabiasQue;
use AppBundle\Entity\Respuesta;
use AppBundle\Entity\UsuarioEmision;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pregunta controller.
 *
 */
class PreguntaController extends FOSRestController
{
    /**
     * @Rest\Get("/pregunta/index/{id}")
     */
    public function getIndexAction(Categoria $categoria)
    {
      $em = $this->getDoctrine()->getManager();
      $preguntas = $em->getRepository('AppBundle:Pregunta')->findByCategoria($categoria->getId());
      $sabiasQue = $em->getRepository('AppBundle:SabiasQue')->findAll();
      $conteoSQ = count($sabiasQue); 

      if ($preguntas != null) {
        foreach ($preguntas as $key => $p) {
           $preguntasArray[$key] = array
            (
            'contenido' => $p->getContenido(), 
            'icono' => $p->getIcono(),
            'respuestas' => $this->getRespuestas($p->getId()),
            'sabiasQue' => $this->getSabiasQue($p->getId()),
            
            );
        }
      }else{
        $preguntasArray = null;
      }

      	return $response = array(
      		'status' => "success",
          'nombreCategoria' => $categoria->getNombre(),
      		'preguntas' => $preguntasArray,
          'conteoSQ' => $conteoSQ
      	);
    }

    
    public function getRespuestas($id){
      $em = $this->getDoctrine()->getManager();
      $respuestas = $em->getRepository('AppBundle:Respuesta')->findByPregunta($id);


      if ($respuestas != null) {
        foreach ($respuestas as $key => $r) {
         $respuestasArray[$key] = array
          (
            'id'=>$r->getId(),
            'contenido' => $r->getNombre(), 
            'icono' => $r->getIcono(),
          );
        }
      }else{
        $respuestasArray = null;
      }
      
      return $respuestasArray;
    }

    public function getSabiasQue($id){
      $em = $this->getDoctrine()->getManager();
      $sabiasQue = $em->getRepository('AppBundle:SabiasQue')->findByPregunta($id);

      if ($sabiasQue != null) {
        foreach ($sabiasQue as $key => $r) {
         $sabiasQueArray[$key] = array
          (
            'contenido' => $r->getTexto(), 
            'icono' => $r->getImagen(),
          );
        }
      }else{
        $sabiasQueArray = null;
      }
      
      return $sabiasQueArray;
    }


    /**
     * @Rest\Get("/sabias/que/{id}")
     */
    public function getSabiasQueAction(SabiasQue $sabiasQue)
    {
      $sabiasQueArray = array(
        'id' => $sabiasQue->getId(), 
        'contenido' => $sabiasQue->getTexto(), 
        'icono' => $sabiasQue->getImagen(), 
      );
      return $response = array(
        'sabiasQue' => $sabiasQueArray
      );
    }

    /**
     * @Rest\Post("/respuesta/marcada/{id}")
     */
    public function postRespuestaMarcadaAction(Respuesta $respuesta, Request $request)
    {
      $fecha = new \DateTime("now");
      $data = $request->getContent();
      $params = json_decode($data);

      $em = $this->getDoctrine()->getManager();

      
      $usuario = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->username);
     

      $usuarioEmision = $em->getRepository('AppBundle:UsuarioEmision')->findEmisionesExistentesPorPregunta($respuesta->getPregunta()->getId(),$usuario->getId(),$fecha);


     if ($usuarioEmision == null) {
      $usuarioEmision = new UsuarioEmision();

      $usuarioEmision->setUsuario($usuario);
      $usuarioEmision->setRespuesta($respuesta);

      $usuarioEmision->setCalculoCo2($respuesta->getPuntaje());
      $usuarioEmision->setCantidadArboles(($respuesta->getPuntaje())/(0.3));

      $em->persist($usuarioEmision);
      $em->flush();
     }else{
      $usuarioEmision->setCalculoCo2($respuesta->getPuntaje());
      $usuarioEmision->setCantidadArboles(($respuesta->getPuntaje())/(0.3));
      $em->flush();
     }
     
    }

    /**
     * @Rest\Post("/pregunta/respuestas/")
    */
    public function postUsuarioEmisionAction(Request $request)
    {
      $fecha = new \DateTime("now");
      $em = $this->getDoctrine()->getManager();
      $data = $request->getContent();
      $params = json_decode($data);
      $calculoC02 = 0;
      $arboles = 0;
      $preguntas = count($em->getRepository('AppBundle:Pregunta')->findAll());
      $preguntasRespondidas = 0;
     
      $usuario = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->username);
      $usuarioEmision = $em->getRepository('AppBundle:UsuarioEmision')->findEmisionesExistentesPorUsuarioYFecha($usuario->getId(),$fecha);

      $preguntasRespondidas = count($usuarioEmision);     

      foreach ($usuarioEmision as $key => $ue) {
          $calculoC02 = $calculoC02 + $ue->getCalculoCo2();
          $arboles = $arboles + $ue->getCantidadArboles();
      }

      $ueArray = array(
          'calculoC02' => $calculoC02, 
          'arboles' => $arboles, 
          'preguntas' => $preguntas, 
          'preguntasRespondidas' => $preguntasRespondidas, 
      );

       return $response = array(
        'usuarioEmision' => $ueArray
      );
    }

}