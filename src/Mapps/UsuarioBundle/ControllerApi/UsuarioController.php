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
    public function getUserLogeadoAction(Request $request)
    { 
      $data = $request->getContent();
      $params = json_decode($data);
      $em = $this->getDoctrine()->getManager();
      $usuario = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->username);
      $publicaciones = $em->getRepository('AppBundle:publicacion')->findByUsuarioEmisor($usuario->getId());

      if ($publicaciones != null) {
        foreach ($publicaciones as $key => $p) {
            $publicacionesArray[$key] = array(
            'contenido' => $p->getContenido(), 
            'id' => $p->getId(), 
            'imagen' => $p->getImagen(), 
            'urlVideo' => $p->getUrlVideoYutube(), 
            'fecha' => $p->getCreatedAt(), 
            );
        }
      }else{
        $publicacionesArray = null;
      }
      

      $usuarioArray = array(
      'username' => $usuario->getUsername(), 
      'fotoPerfil' => $usuario->getFotoPerfil(), 
      'fotoPortada' => $usuario->getFotoPortada(), 
      'nombres' => $usuario->getNombres(), 
      'apellidos' => $usuario->getApellidos(), 
      );
      
      $response = array(
          'status' => "success",
          'msj' => "Lista de Usuarios",
          'usuario' => $usuarioArray,
          'publicaciones' => $publicacionesArray,
      );
      return $response;
    }
}
