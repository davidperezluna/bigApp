<?php

namespace Mapps\UsuarioBundle\ControllerApi;

use Mapps\UsuarioBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Categoria controller.
 *
 */
class CategoriaController extends FOSRestController
{
    /**
     * @Rest\Get("/categoria/")
     */
    public function getIndexAction()
    {
    	
    	$em = $this->getDoctrine()->getManager();
      $categorias = $em->getRepository('AppBundle:Categoria')->findAll();

      	return $response = array(
      		'status' => "success",
      		'categorias' => $categorias
      	);
    }

}