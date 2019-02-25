<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\Empresa;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * EmpresaController controller.
 *
 */
class EmpresaController extends FOSRestController
{
    /**
     * @Rest\POST("/empresa/list/paginator")
     */
    public function postIndexPaginatorAction(Request $request)
    {
      $data = $request->getContent();
      $params = json_decode($data);
      $em    = $this->get('doctrine.orm.entity_manager');
      $dql   = "SELECT e FROM AppBundle:Empresa e";
      $query = $em->createQuery($dql);

      $paginator  = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
          $query, /* query NOT result */
          $request->query->getInt('page', $params->idPagina)/*page number*/,
          5/*limit per page*/
      );

      $empresas = $query->getResult();

      if ($empresas != null) {
        foreach ($empresas as $key => $empresa) {
          $empresasArray[$key] = array
            (
            'descripcion' => $empresa->getDescripcion(),
            'id' => $empresa->getId(),
            'nombreEmpresa' => $empresa->getNombre(),
            'logoEmpresa' => $empresa->getFotoLogo(),
            'portadaEmpresa' => $empresa->getFotoPortada(),
            'nombreMunicipio' => $empresa->getMunicipio()->getNombre(),
            'lat' => $empresa->getLat(),
            'lng' => $empresa->getLng(),
            'fecha' => $empresa->getCreatedAt(),

            );
        }
      }else{
        $empresasArray = null;
      }

      return $response = array(
        'status' => "success",
        'datos' => $empresasArray,
      );
    }
    
    /**
     * @Rest\Get("/empresa/index")
     */
    public function getIndexAction()
    {
      $em = $this->getDoctrine()->getManager();
      $helpers = $this->get("app.helpers");
      $empresas = $em->getRepository('AppBundle:Empresa')->findAll();
      if ($empresas != null) {
        foreach ($empresas as $key => $empresa) {
          $empresasArray[$key] = array
            (
            'descripcion' => $empresa->getDescripcion(),
            'id' => $empresa->getId(),
            'nombreEmpresa' => $empresa->getNombre(),
            'logoEmpresa' => $empresa->getFotoLogo(),
            'nombreMunicipio' => $empresa->getMunicipio()->getNombre(),
            'lat' => $empresa->getLat(),
            'lng' => $empresa->getLng(),
            'fecha' => $empresa->getCreatedAt(),
            );
        }
      }else{
        $empresasArray = null;
      }

      return $response = array(
        'status' => "success",
        'datos' => $empresasArray,
      );
    }

    /**
     * @Rest\Post("/empresa/filtro")
     */
    public function getEmpresaFiltroAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $data = $request->getContent();
      $params = json_decode($data);
      $empresas = $em->getRepository('AppBundle:Empresa')->findEmpresaPorNombre($params->tags,$params->municipioEmpresaId);
      if ($empresas != null) {
        foreach ($empresas as $key => $empresa) {
          $empresasArray[$key] = array
            (
            'nombre' => $empresa->getNombre(), 
            'id' => $empresa->getId(),
            'descripcion' => $empresa->getDescripcion(),
            'nombreEmpresa' => $empresa->getNombre(),
            'logoEmpresa' => $empresa->getFotoLogo(),
            'nombreMunicipio' => $empresa->getMunicipio()->getNombre(),
            'lat' => $empresa->getLat(),
            'lng' => $empresa->getLng(),
            'fecha' => $empresa->getCreatedAt(),
            );
        }
      }else{
        $empresasArray = null;
      }

      return $response = array(
        'status' => "success",
        'datos' => $empresasArray,
      );
    }

    /**
     * @Rest\Post("/empresa/show")
     */
    public function getEmpresaShowAction(Request $request)
    { 
      $data = $request->getContent();
      $params = json_decode($data);
      $em = $this->getDoctrine()->getManager();
      $empresa = $em->getRepository('AppBundle:Empresa')->find($params->id);

      $productos = $em->getRepository('AppBundle:Producto')->findByEmpresa($params->id);
      $redes = $em->getRepository('AppBundle:EmpresaRedes')->findByEmpresa($params->id);

      if ($redes) {
        foreach ($redes as $key => $red) {
          $redesArray[$key] = array(
            'nombre' => $red->getNombre(), 
            'url' => $red->getUrlRedSocial(), 

          ); 
        }
      }else{
        $redesArray = null;
      }

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
      

      $empresaArray = array(
        'nombre' => $empresa->getNombre(), 
        'descripcion' => $empresa->getDescripcion(),
        'logo' => $empresa->getFotoLogo(),
        'portada' => $empresa->getFotoPortada(),
        'municipio' => $empresa->getMunicipio()->getNombre(),
        'lat' => $empresa->getLat(),
        'lng' => $empresa->getLng(),
        'fecha' => $empresa->getCreatedAt(), 
      );
      
      $response = array(
          'status' => "success",
          'msj' => "Lista de Usuarios",
          'empresa' => $empresaArray,
          'productos' => $productosArray,
          'redes' => $redesArray,
      );
      return $response;
    }

}