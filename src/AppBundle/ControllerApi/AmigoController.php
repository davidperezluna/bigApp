<?php

namespace AppBundle\ControllerApi;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AmigoController controller.
 *
 */
class AmigoController extends FOSRestController
{
     /**
     * @Rest\Post("amigo/find/user")
     */
    public function postBuscarAmigoAction(Request $request)
    { 
        
        $em = $this->getDoctrine()->getManager();
        $data = $request->getContent();
        $params = json_decode($data);

        $stringBusqueda = $params->stringBusqueda;
       

        $user = $em->getRepository('MappsUsuarioBundle:User')->findOneByEmail($stringBusqueda);

        return $response = array(
            'status' => "success",
            'user' => $user,
        );
    }

}