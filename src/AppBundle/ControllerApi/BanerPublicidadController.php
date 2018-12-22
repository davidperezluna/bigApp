<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\BanerPublicidad;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * BanerPublicidadController controller.
 *
 */
class BanerPublicidadController extends FOSRestController
{
    /**
     * @Rest\POST("/banerPublicidad/list/paginator")
     */
    public function postIndexPaginatorAction(Request $request)
    {
      $data = $request->getContent();
      $params = json_decode($data);
      $em    = $this->get('doctrine.orm.entity_manager');
      $dql   = "SELECT bp FROM AppBundle:BanerPublicidad bp";
      $query = $em->createQuery($dql);

      $paginator  = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
          $query, /* query NOT result */
          $request->query->getInt('page', $params->idPagina)/*page number*/,
          4/*limit per page*/
      );

      $banerPublicidads = $query->getResult();

      if ($banerPublicidads != null) {
        foreach ($banerPublicidads as $key => $banerPublicidad) {
          $banerPublicidadsArray[$key] = array
            (
            'url' => $banerPublicidad->getUrl(),
            );
        }
      }else{
        $banerPublicidadsArray = null;
      }

      return $response = array(
        'status' => "success",
        'datos' => $banerPublicidadsArray,
      );
    }
    
    /**
     * @Rest\Get("/banerPublicidad/index")
     */
    public function getIndexAction()
    {
      $em = $this->getDoctrine()->getManager();
      $helpers = $this->get("app.helpers");
      $banerPublicidads = $em->getRepository('AppBundle:BanerPublicidad')->findAll();
      if ($banerPublicidads != null) {
        foreach ($banerPublicidads as $key => $banerPublicidad) {
          $banerPublicidadsArray[$key] = array
            (
            'descripcion' => $banerPublicidad->getDescripcion(),
            'id' => $banerPublicidad->getId(),
            'nombreBanerPublicidad' => $banerPublicidad->getNombre(),
            'logoBanerPublicidad' => $banerPublicidad->getFotoLogo(),
            'nombreMunicipio' => $banerPublicidad->getMunicipio()->getNombre(),
            'fecha' => $banerPublicidad->getCreatedAt(),
            );
        }
      }else{
        $banerPublicidadsArray = null;
      }

      return $response = array(
        'status' => "success",
        'datos' => $banerPublicidadsArray,
      );
    }

    /**
     * @Rest\Post("/banerPublicidad/filtro")
     */
    public function getBanerPublicidadFiltroAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $data = $request->getContent();
      $params = json_decode($data);
      $banerPublicidads = $em->getRepository('AppBundle:BanerPublicidad')->findBanerPublicidadPorNombre($params->tags,$params->municipioBanerPublicidadId);
      if ($banerPublicidads != null) {
        foreach ($banerPublicidads as $key => $banerPublicidad) {
          $banerPublicidadsArray[$key] = array
            (
            'nombre' => $banerPublicidad->getNombre(), 
            'id' => $banerPublicidad->getId(),
            'descripcion' => $banerPublicidad->getDescripcion(),
            'nombreBanerPublicidad' => $banerPublicidad->getNombre(),
            'logoBanerPublicidad' => $banerPublicidad->getFotoLogo(),
            'nombreMunicipio' => $banerPublicidad->getMunicipio()->getNombre(),
            'fecha' => $banerPublicidad->getCreatedAt(),
            );
        }
      }else{
        $banerPublicidadsArray = null;
      }

      return $response = array(
        'status' => "success",
        'datos' => $banerPublicidadsArray,
      );
    }

    /**
     * @Rest\Post("/banerPublicidad/show")
     */
    public function getBanerPublicidadShowAction(Request $request)
    { 
      $data = $request->getContent();
      $params = json_decode($data);
      $em = $this->getDoctrine()->getManager();
      $banerPublicidad = $em->getRepository('AppBundle:BanerPublicidad')->find($params->id);

      $banerPublicidadArray = array(
        'nombre' => $banerPublicidad->getNombre(), 
        'descripcion' => $banerPublicidad->getDescripcion(),
        'logo' => $banerPublicidad->getFotoLogo(),
        'portada' => $banerPublicidad->getFotoPortada(),
        'municipio' => $banerPublicidad->getMunicipio()->getNombre(),
        'municipio' => $banerPublicidad->getMunicipio()->getNombre(),
        'lat' => $banerPublicidad->getLat(),
        'lng' => $banerPublicidad->getLng(),
        'fecha' => $banerPublicidad->getCreatedAt(), 
      );
      
      $response = array(
          'status' => "success",
          'msj' => "Lista de Usuarios",
          'banerPublicidad' => $banerPublicidadArray,
      );
      return $response;
    }

}