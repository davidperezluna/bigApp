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
      $publicaciones = $em->getRepository('AppBundle:publicacion')->findBy(
        array('usuarioReceptor'=> $usuario->getId()), 
        array('createdAt' => 'DESC')
      );
      $empresa = $em->getRepository('AppBundle:Empresa')->findOneByUsuario($usuario->getId());
      $empresaId = null;
      if ($empresa) {
        $empresaId = $empresa->getId();
      }

      // var_dump($empresaId);
      // die();

      if ($publicaciones != null) {
        foreach ($publicaciones as $key => $p) {
            $publicacionesArray[$key] = array(
            'contenido' => $p->getContenido(), 
            'id' => $p->getId(), 
            'imagen' => $p->getImagen(), 
            'urlVideo' => $p->getUrlVideoYutube(), 
            'fecha' => $p->getCreatedAt(), 
            'fotoPerfil'=> $p->getUsuarioEmisor()->getFotoPerfil(),
            'nombres'=> $p->getUsuarioEmisor()->getNombres()
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
      'oneSignalId'=> $usuario->getPlayerId(),
      'empresaId'=> $empresaId,
      );
      
      $response = array(
          'status' => "success",
          'msj' => "Lista de Usuarios",
          'usuario' => $usuarioArray,
          'publicaciones' => $publicacionesArray,
      );
      return $response;
    }


    /**
     * @Rest\Post("/usuario/new")
     */
    public function postUserNewAction(Request $request)
    { 
      $em = $this->getDoctrine()->getManager();
      $data = $request->getContent();
      $params = json_decode($data);

      $user = new User();
      $factory = $this->get("security.encoder_factory");
      $encoder = $factory->getEncoder($user);
      $passwordd =$params->password;
      $password = $encoder->encodePassword($passwordd, $user->getSalt());


      $user->setUsername($params->username);
      $user->setNombres($params->nombres);
      $user->setApellidos($params->apellidos);
      $user->setEmail($params->email);
      $user->setCelular($params->celular);
      $user->setPassword($password);
      $user->setEnabled(0);
      $user->setFotoPerfil("user.png");
      $user->setFotoPortada("portadaDefault.jpg");
      
      $em->persist($user);
      $em->flush();
      $user->setEnabled(0);
      $em->flush($user);
      
      
      $response = array(
          'status' => "success",
          'msj' => "Usuario Creado",
      );
      return $response;
    }


    /**
     * @Rest\Post("/usuario/fotosperfil")
     */
    public function postFotosPerfilAction(Request $request)
    { 
        
        $em = $this->getDoctrine()->getManager();

        $imagen = $request->files->get("ionicfile");

        $tipo = $request->request->get("tipo");
        $username = $request->request->get("usuario");

        $usuario = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($username);

        if($tipo == "portada"){
          $rutaSubida = $this->getParameter('portada_usuario_directory');
        }else{
          $rutaSubida = $this->getParameter('perfil_usuario_directory');
          
        }
        

        $urlImagenName =  md5(uniqid()).'.'.$imagen->guessExtension();
        $imagen->move(
            $rutaSubida,
            $urlImagenName
        );

        if($tipo=="portada"){
          $usuario->setFotoPortada($urlImagenName);
        }else{
          $usuario->setFotoPerfil($urlImagenName);
        }

        $em->persist($usuario);
        $em->flush(); 

        return $response = array(
            'status' => "success",
            'datos' => $urlImagenName,
        );
    }


    /**
     * @Rest\POST("/usuario/publicaciones/list/paginator")
     */
  public function postListPublicacionesAction(Request $request)
  {

      $data = $request->getContent();
      $params = json_decode($data);
      $em    = $this->get('doctrine.orm.entity_manager');
      $dql   = "SELECT p FROM AppBundle:Publicacion p order by p.createdAt desc";
      $query = $em->createQuery($dql);

     
      $paginator  = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
          $query, /* query NOT result */
          $request->query->getInt('page', $params->idPagina)/*page number*/,
          3/*limit per page*/
      );

      $publicaciones = $query->getResult();

      if ($publicaciones != null) {
        foreach ($publicaciones as $key => $p) {
            $publicacionesArray[$key] = array(
            'contenido' => $p->getContenido(), 
            'id' => $p->getId(), 
            'imagen' => $p->getImagen(), 
            'urlVideo' => $p->getUrlVideoYutube(), 
            'fecha' => $p->getCreatedAt(), 
            'fotoPerfil'=> $p->getUsuarioEmisor()->getFotoPerfil(),
            'nombres'=> $p->getUsuarioEmisor()->getNombres()
            );
        }
      }else{
        $publicacionesArray = null;
      }

      return $response = array(
        'status' => "success",
        'publicaciones' => $publicacionesArray,
      );
      // parameters to template
  }




  /**
     * @Rest\Post("/usuario/set/player/id")
     */
    public function postSetPlayerIdAction(Request $request)
    { 
      $em = $this->getDoctrine()->getManager();
      $data = $request->getContent();
      $params = json_decode($data);

      $usuario = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->username);
      $playerId = $params->playerId;

      $usuario->setPlayerId($playerId);
      $em->flush($usuario);
      
      
      $response = array(
          'status' => "success",
          'msj' => "Player Id Añadido",
      );
      return $response;
    }

}
