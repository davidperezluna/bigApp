<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\Subasta;
use AppBundle\Entity\SubastaProducto;
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

        $subastas = $em->getRepository('AppBundle:Subasta')->findBy(
            array('usuario'=> $usuario->getId()), 
            array('createdAt' => 'DESC')
          );
       
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

    /**
     * @Rest\Post("/subasta/new")
     */
    public function postCrearSubastaAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $data = $request->getContent();
      $params = json_decode($data);
      $fechaHoy = new \DateTime("now");
      
      $fechaHoy = new \DateTime("now");
      $usuario = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->usuario);

      $municipio = $em->getRepository('AppBundle:Municipio')->find($params->municipio);
      $categoria = $em->getRepository('AppBundle:EmpresaSubCategoria')->find($params->categoria);

      $productos = $em->getRepository('AppBundle:Producto')->findProductosPorNombreCategoriaMunicipio($params->contenido,$params->municipio,$params->categoria);
        
      $subasta = new Subasta();
      $subasta->setUsuario($usuario);
      $subasta->setMunicipio($municipio);
      $subasta->setCategoria($categoria);
      $subasta->setCreatedAt($fechaHoy);
      $subasta->setPeticion($params->contenido);
      $subasta->setEstado('solicitado');
     
      $em->persist($subasta);
      $em->flush(); 

      $arrayPlayersId = array();
      $cantidadProductos=count($productos)-1;
    //   var_dump($cantidadProductos);
      foreach ($productos as $key => $producto) {
        // var_dump($key);
        // if ($cantidadProductos == $key) {
        //     $arrayPlayersId= ;
        // } else {
        //     $arrayPlayersId=$arrayPlayersId.$producto->getEmpresa()->getUsuario()->getPlayerId().'","';
        // }
        array_push($arrayPlayersId,$producto->getEmpresa()->getUsuario()->getPlayerId());

        //   $arrayPlayersId=$arrayPlayersId.$producto->getEmpresa()->getUsuario()->getPlayerId().",";
          $subastaProducto = new SubastaProducto();
          $subastaProducto->setEmpresa($producto->getEmpresa());
          $subastaProducto->setProducto($producto);
          $subastaProducto->setSubasta($subasta);
          $em->persist($subastaProducto);
          $em->flush(); 
        }
        // var_dump($arrayPlayersId);
        // die(); 
      return $response = array(
        'status' => "success",
        'msj' => "subasta creada",
        'arrayPlayersId' => $arrayPlayersId,
        'contenido' => $usuario->getNombres().' : '. $params->contenido,
        
      );
    }
}
