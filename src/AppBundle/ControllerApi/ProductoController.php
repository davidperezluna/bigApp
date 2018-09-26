<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\Producto;
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
                'nombre' => $p->getNombre(), 
                'descripcion' => $p->getDescripcion(),
                'nombreEmpresa' => $p->getEmpresa()->getNombre(),
                'logoEmpresa' => $p->getEmpresa()->getFotoLogo(),
                'imagen' => $imagen->getImagen(),
                'valor' => $p->getValor(),
                'subCategoria' => $p->getSubCategoria()->getNombre(),
                'fecha' => $p->getCreatedAt(),
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
                'nombre' => $p->getNombre(), 
                'descripcion' => $p->getDescripcion(),
                'nombreEmpresa' => $p->getEmpresa()->getNombre(),
                'logoEmpresa' => $p->getEmpresa()->getFotoLogo(),
                'imagen' => $imagen->getImagen(),
                'valor' => $p->getValor(),
                'subCategoria' => $p->getSubCategoria()->getNombre(),
                'fecha' => '1994-03-01',
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
                'nombre' => $p->getNombre(), 
                'descripcion' => $p->getDescripcion(),
                'nombreEmpresa' => $p->getEmpresa()->getNombre(),
                'logoEmpresa' => $p->getEmpresa()->getFotoLogo(),
                'imagen' => $imagen->getImagen(),
                'valor' => $p->getValor(),
                'subCategoria' => $p->getSubCategoria()->getNombre(),
                'fecha' => '1994-03-01',
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

}