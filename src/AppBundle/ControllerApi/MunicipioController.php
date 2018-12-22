<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\Municipio;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Municipio controller.
 *
 */
class MunicipioController extends FOSRestController
{
    /**
     * @Rest\Get("/municipio/index")
     */
    public function getIndexAction()
    {
    	
    	$em = $this->getDoctrine()->getManager();
      $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
      foreach ($municipios as $key => $m) {
       $municipiosArray[$key] = array
        (
        'id' => $m->getId(),
        'nombre' => $m->getNombre(), 
        );
      }

      	return $response = array(
      		'status' => "success",
      		'datos' => $municipiosArray
      	);
    }

}