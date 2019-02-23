<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\MedioPago;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * MedioPago controller.
 *
 */
class MedioPagoController extends FOSRestController
{
    /**
     * @Rest\Get("/medioPago/index")
     */
    public function getIndexAction()
    {
    	
    	$em = $this->getDoctrine()->getManager();
      $medioPagos = $em->getRepository('AppBundle:MedioPago')->findAll();
      foreach ($medioPagos as $key => $m) {
       $medioPagosArray[$key] = array
        (
        'id' => $m->getId(),
        'nombre' => $m->getNombre(), 
        );
      }

      	return $response = array(
      		'status' => "success",
      		'mediosPago' => $medioPagosArray
      	);
    }

}