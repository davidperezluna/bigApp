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

      $empresaArray = array(
        'nombre' => $empresa->getNombre(), 
        'descripcion' => $empresa->getDescripcion(),
        'logo' => $empresa->getFotoLogo(),
        'portada' => $empresa->getFotoPortada(),
        'municipio' => $empresa->getMunicipio()->getNombre(),
        'municipio' => $empresa->getMunicipio()->getNombre(),
        'lat' => $empresa->getLat(),
        'lng' => $empresa->getLng(),
        'fecha' => $empresa->getCreatedAt(), 
      );
      
      $response = array(
          'status' => "success",
          'msj' => "Lista de Usuarios",
          'empresa' => $empresaArray,
      );
      return $response;
    }

}