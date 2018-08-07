<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\Categoria;
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
     * @Rest\Get("/categoria/index")
     */
    public function getIndexAction()
    {
    	
    	$em = $this->getDoctrine()->getManager();
      $categorias = $em->getRepository('AppBundle:EmpresaSubCategoria')->findAll();
      foreach ($categorias as $key => $c) {
       $categoriasArray[$key] = array
        (
        'id' => $c->getId(),
        'nombre' => $c->getNombre(), 
        );
      }

      	return $response = array(
      		'status' => "success",
      		'categorias' => $categoriasArray
      	);
    }

}