<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\Producto;
use Symfony\Component\HttpFoundation\Session\Session;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ProductoController controller.
 *
 */
class ProductoController extends FOSRestController
{ 

  /**
     * @Rest\POST("/producto/list/paginator")
     */
  public function postListAction(Request $request)
  {

      // $session = new Session();
      // $session->start();
      // $session->set('username', 'admin');

      

      $data = $request->getContent();
      $params = json_decode($data);
      $em    = $this->get('doctrine.orm.entity_manager');
      $dql   = "SELECT p FROM AppBundle:Producto p";
      $query = $em->createQuery($dql);

      $paginator  = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
          $query, /* query NOT result */
          $request->query->getInt('page', $params->idPagina)/*page number*/,
          5/*limit per page*/
      );

      $productos = $query->getResult();

      if ($productos != null) {
        foreach ($productos as $key => $p) {
          foreach ($p->getImagenes() as $keyImegen => $imagen) {
            if ($keyImegen==0) {
              $productosArray[$key] = array
                (
                'id' => $p->getId(), 
                'idEmpresa' => $p->getEmpresa()->getId(), 
                'nombreProducto' => $p->getNombre(), 
                'descripcion' => $p->getDescripcion(),
                'nombreEmpresa' => $p->getEmpresa()->getNombre(),
                'logoEmpresa' => $p->getEmpresa()->getFotoLogo(),
                'lat' => $p->getEmpresa()->getLat(),
                'lng' => $p->getEmpresa()->getLng(),
                'imagen' => $imagen->getImagen(),
                'valor' => $p->getValor(),
                'subCategoria' => $p->getSubCategoria()->getNombre(),
                'fecha' => $p->getCreatedAt(),
                //chat  
                'conversacionId' => null,
                'nombre' => $p->getEmpresa()->getUsuario()->getNombres(),
                'username' => $p->getEmpresa()->getUsuario()->getUsername(),
                'foto' => $p->getEmpresa()->getUsuario()->getFotoPerfil(),
                'usuarioId' => $p->getEmpresa()->getUsuario()->getId(),
                'oneSignalId' => $p->getEmpresa()->getUsuario()->getPlayerId(),
                );
            }
          }  
        }
      }else{
        $productosArray = null;
      }

      return $response = array(
        'status' => "success",
        'datos' => $productosArray,
      );
      // parameters to template
  }

    /**
     * @Rest\Get("/producto/index")
     */
    public function getIndexAction()
    {
      $em = $this->getDoctrine()->getManager();
      $helpers = $this->get("app.helpers");
      $productos = $em->getRepository('AppBundle:Producto')->findAll();
      if ($productos != null) {
        foreach ($productos as $key => $p) {
          foreach ($p->getImagenes() as $keyImegen => $imagen) {
            if ($keyImegen==0) {
              $productosArray[$key] = array
                (
                'id' => $p->getId(), 
                'idEmpresa' => $p->getEmpresa()->getId(),
                'nombreProducto' => $p->getNombre(), 
                'descripcion' => $p->getDescripcion(),
                'nombreEmpresa' => $p->getEmpresa()->getNombre(),
                'logoEmpresa' => $p->getEmpresa()->getFotoLogo(),
                'lat' => $p->getEmpresa()->getLat(),
                'lng' => $p->getEmpresa()->getLng(),
                'imagen' => $imagen->getImagen(),
                'valor' => $p->getValor(),
                'valor' => $p->getValor(),
                'subCategoria' => $p->getSubCategoria()->getNombre(),
                'fecha' => $p->getCreatedAt(),
                //chat  
                'conversacionId' => null,
                'nombre' => $p->getEmpresa()->getUsuario()->getNombres(),
                'username' => $p->getEmpresa()->getUsuario()->getUsername(),
                'foto' => $p->getEmpresa()->getUsuario()->getFotoPerfil(),
                'usuarioId' => $p->getEmpresa()->getUsuario()->getId(),
                'oneSignalId' => $p->getEmpresa()->getUsuario()->getPlayerId(),
                );
            }
          }  
        }
      }else{
        $productosArray = null;
      }

      return $response = array(
        'status' => "success",
        'datos' => $productosArray,
      );
    }

    /**
     * @Rest\Post("/producto/tag")
     */
    public function getProductoTagAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $data = $request->getContent();
      $params = json_decode($data);
      $productos = $em->getRepository('AppBundle:Producto')->findProductosPorNombre($params->tags,$params->categoriaId,$params->municipioId);
      if ($productos != null) {
        foreach ($productos as $key => $p) {
          foreach ($p->getImagenes() as $keyImegen => $imagen) {
            if ($keyImegen==0) {
              $productosArray[$key] = array
                (
                'id' => $p->getId(),
                'idEmpresa' => $p->getEmpresa()->getId(),
                'nombreProducto' => $p->getNombre(), 
                'descripcion' => $p->getDescripcion(),
                'nombreEmpresa' => $p->getEmpresa()->getNombre(),
                'logoEmpresa' => $p->getEmpresa()->getFotoLogo(),
                'imagen' => $imagen->getImagen(),
                'valor' => $p->getValor(),
                'lat' => $p->getEmpresa()->getLat(),
                'lng' => $p->getEmpresa()->getLng(),
                'valor' => $p->getValor(),
                'subCategoria' => $p->getSubCategoria()->getNombre(),
                'fecha' => $p->getCreatedAt(),
                //chat  
                'conversacionId' => null,
                'nombre' => $p->getEmpresa()->getUsuario()->getNombres(),
                'username' => $p->getEmpresa()->getUsuario()->getUsername(),
                'foto' => $p->getEmpresa()->getUsuario()->getFotoPerfil(),
                'usuarioId' => $p->getEmpresa()->getUsuario()->getId(),
                'oneSignalId' => $p->getEmpresa()->getUsuario()->getPlayerId(),
                );
            }
          }
        }
      }else{
        $productosArray = null;
      }

      return $response = array(
        'status' => "success",
        'datos' => $productosArray,
      );
    }

    /**
     * @Rest\Post("/producto/filtro")
     */
    public function getProductoFiltroAction(Request $request)
    {

      $em = $this->getDoctrine()->getManager();
      $data = $request->getContent();
      $params = json_decode($data);
      $productos = $em->getRepository('AppBundle:Producto')->findProductosPorNombre($params->tags,$params->categoriaId,$params->municipioId);
      if ($productos != null) {
        foreach ($productos as $key => $p) {
          foreach ($p->getImagenes() as $keyImegen => $imagen) {
            if ($keyImegen==0) {
              $productosArray[$key] = array
                (
                'id' => $p->getId(),
                'idEmpresa' => $p->getEmpresa()->getId(),
                'nombreProducto' => $p->getNombre(), 
                'descripcion' => $p->getDescripcion(),
                'nombreEmpresa' => $p->getEmpresa()->getNombre(),
                'logoEmpresa' => $p->getEmpresa()->getFotoLogo(),
                'imagen' => $imagen->getImagen(),
                'valor' => $p->getValor(),
                'lat' => $p->getEmpresa()->getLat(),
                'lng' => $p->getEmpresa()->getLng(),
                'valor' => $p->getValor(),
                'subCategoria' => $p->getSubCategoria()->getNombre(),
                'fecha' => $p->getCreatedAt(),
                'conversacionId' => null,
                 //chat  
                'conversacionId' => null,
                'nombre' => $p->getEmpresa()->getUsuario()->getNombres(),
                'username' => $p->getEmpresa()->getUsuario()->getUsername(),
                'foto' => $p->getEmpresa()->getUsuario()->getFotoPerfil(),
                'usuarioId' => $p->getEmpresa()->getUsuario()->getId(),
                'oneSignalId' => $p->getEmpresa()->getUsuario()->getPlayerId(),
                );
            }
          }
        }
      }else{
        $productosArray = null;
      }

      return $response = array(
        'status' => "success",
        'datos' => $productosArray,
      );
    }


    /**
     * @Rest\POST("/producto/buscar/general")
     */
  public function postBuscarGeneralAction(Request $request)
  {

      $data = $request->getContent();
      $params = json_decode($data);
      $em    = $this->get('doctrine.orm.entity_manager');

      $productos = $em->getRepository('AppBundle:Producto')->findProductosPorNombre($params->stringBusqueda,'','');

      if ($productos != null) {
        foreach ($productos as $key => $p) {
          foreach ($p->getImagenes() as $keyImegen => $imagen) {
            if ($keyImegen==0) {
              $productosArray[$key] = array
                (
                'id' => $p->getId(), 
                'idEmpresa' => $p->getEmpresa()->getId(), 
                'nombreProducto' => $p->getNombre(), 
                'descripcion' => $p->getDescripcion(),
                'nombreEmpresa' => $p->getEmpresa()->getNombre(),
                'logoEmpresa' => $p->getEmpresa()->getFotoLogo(),
                'lat' => $p->getEmpresa()->getLat(),
                'lng' => $p->getEmpresa()->getLng(), 
                'imagen' => $imagen->getImagen(),
                'valor' => $p->getValor(),
                'subCategoria' => $p->getSubCategoria()->getNombre(),
                'fecha' => $p->getCreatedAt(),
                 //chat  
                 'conversacionId' => null,
                 'nombre' => $p->getEmpresa()->getUsuario()->getNombres(),
                 'username' => $p->getEmpresa()->getUsuario()->getUsername(),
                 'foto' => $p->getEmpresa()->getUsuario()->getFotoPerfil(),
                 'usuarioId' => $p->getEmpresa()->getUsuario()->getId(),
                 'oneSignalId' => $p->getEmpresa()->getUsuario()->getPlayerId(),
                );
            }
          }  
        }
      }else{
        $productosArray = null;
      }

      return $response = array(
        'status' => "success",
        'productos' => $productosArray,
      );
      // parameters to template
  }

}