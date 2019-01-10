<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\Subasta;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * SubastaController controller.
 *
 */
class SubastaController extends FOSRestController
{
    /**
     * @Rest\Post("subasta/")
     */
    public function postIndexAction(Request $request)
    {
        $data = $request->getContent();
        $params = json_decode($data);
        $subastasArray = null;

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->username);
        $subastas = $em->getRepository('AppBundle:Subasta')->findByUsuario($usuario->getId());
       
        foreach ($subastas as $key => $subasta) {
        $subastasArray[$key] = array
            (
            'id' => $subasta->getId(),
            'peticion' => $subasta->getPeticion(), 
            'fecha' => $subasta->getCreatedAt(),
            'fotoPerfil'=> $subasta->getUsuario()->getFotoPerfil(),
            );
        }
        $usuarioArray = array(
            'username' => $usuario->getUsername(), 
            'fotoPerfil' => $usuario->getFotoPerfil(), 
            'fotoPortada' => $usuario->getFotoPortada(), 
            'nombres' => $usuario->getNombres(), 
            'apellidos' => $usuario->getApellidos(), 
        );

      	return $response = array(
            'status' => "success",
            'usuario' => $usuarioArray,
      		'subastas' => $subastasArray
      	);
    }
}
