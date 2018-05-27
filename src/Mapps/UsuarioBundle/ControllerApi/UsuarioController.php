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
 * Usuario controller.
 *
 */
class UsuarioController extends FOSRestController
{
    /**
     * @Rest\Post("/usuario/logeado")
     */
    public function getLoginAction(Request $request)
    {
    	$data = $request->getContent();
    	$params = json_decode($data);
    	$em = $this->getDoctrine()->getManager();
      	$usuario = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->username);

        $user = array(
          'id' => $usuario->getId(), 
          'nombres' => $usuario->getNombres(), 
          'apellidos' => $usuario->getApellidos(), 
          'identificacion' => $usuario->getIdentificacion(), 

        );

      	return $response = array(
      		'status' => "success",
      		'user' => $user
      	);
    }

    /**
     * @Rest\Post("/usuario/new")
     */
    public function postNewUserAction(Request $request)
    {	
    	$em = $this->getDoctrine()->getManager();
    	$user = new User();
    	$data = $request->getContent();
    	$params = json_decode($data);
		  $role = 'ROLE_USER';
    	$user->setNombres($params->nombres);
    	$user->setEmail($params->email);
    	$user->setApellidos($params->apellidos);
    	$user->setIdentificacion($params->identificacion);
    	$user->setCelular($params->celular);
		  $user->setDireccion($params->direccion);
		  $user->setUsername($params->identificacion);
		  $user->setEnabled(1);

    	$factory = $this->get("security.encoder_factory");
        $encoder = $factory->getEncoder($user);
        $passwordd =$params->password;
        $password = $encoder->encodePassword($passwordd, $user->getSalt());

		$user->setPassword($password);
		$user->setRolePersona($role);
	
    	$em->persist($user);
        $em->flush();

       	return $response = array(
      		'status' => "success",
      		'msj' => "Usuario Creado"
      	);
    	
    }

    /**
     * @Rest\Get("/usuario/index/")
     */
    public function getIndexUserAction(Request $request)
    { 
      
      $em = $this->getDoctrine()->getManager();
      $usuarios = $em->getRepository('MappsUsuarioBundle:User')->findAll();

      $response = array(
        'status' => "success",
        'msj' => "Lista de Usuarios",
        "data" => $usuarios
    );
      return $response;
    }
}
