<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\Pedido;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * PedidoController controller.
 *
 */
class PedidoController extends FOSRestController
{

    /**
     * @Rest\Get("pedido/{usuarioId}/index")
     */
    public function postPedidosIndexAction($usuarioId)
    { 
        $em = $this->getDoctrine()->getManager();

        $pedidos = $em->getRepository('AppBundle:Pedido')->findByUsuario($usuarioId);

        foreach ($pedidos as $key => $pedido) {
            $pedidosArray[$key] = array(
                'id'=> $pedido->getUsuario()->getId(),
                'username' => $pedido->getUsuario()->getUsername(), 
                'fotoPerfil' => $pedido->getUsuario()->getFotoPerfil(), 
                'fotoPortada' => $pedido->getUsuario()->getFotoPortada(), 
                'nombres' => $pedido->getUsuario()->getNombres(), 
                'apellidos' => $pedido->getUsuario()->getApellidos(), 
                'descripcion' => $pedido->getDescripcion(),
                'lat' => $pedido->getLat(),
                'lng' => $pedido->getLng(),
                'producto'=>$pedido->getProducto()->getNombre()
    
            );
        }

        return $response = array(
            'status' => "success",
            'pedidos' => $pedidosArray,
        );
    }

     /**
     * @Rest\Post("pedido/new")
     */
    public function postNewPedidoAction(Request $request)
    { 
        
        $em = $this->getDoctrine()->getManager();
        $data = $request->getContent();
        $params = json_decode($data);
        
        $pedido = new Pedido();

        $usuario = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($params->username);
        $medioPago = $em->getRepository('AppBundle:MedioPago')->find($params->medioPagoId);
        $producto = $em->getRepository('AppBundle:Producto')->find($params->productoId);

        $pedido->setUsuario($usuario);
        $pedido->setDescripcion($params->descripcion);
        $pedido->setMedioPago($medioPago);
        $pedido->setProducto($producto);
        $pedido->setEmpresa($producto->getEmpresa());
        $pedido->setDireccion($params->direccion);
        
        $em->persist($pedido);
        $em->flush();

        return $response = array(
            'status' => "success",
            'msg'=>"Pedido creado"
        );
    }


    /**
     * @Rest\Post("pedido/listar/by/empresa")
     */
    public function postListarByEmpresaAction(Request $request)
    { 
        $em = $this->getDoctrine()->getManager();
        $data = $request->getContent();
        $params = json_decode($data);

        $empresaId = $params->empresaId;
        
        $pedidos = $em->getRepository('AppBundle:Pedido')->findByEmpresa($empresaId);
        foreach ($pedidos as $key => $pedido) {
            $pedidosArray[$key] = array(
                'id'=> $pedido->getUsuario()->getId(),
                'username' => $pedido->getUsuario()->getUsername(), 
                'fotoPerfil' => $pedido->getUsuario()->getFotoPerfil(), 
                'nombres' => $pedido->getUsuario()->getNombres(), 
                'apellidos' => $pedido->getUsuario()->getApellidos(), 
                'descripcion' => $pedido->getDescripcion(),
                'direccion' => $pedido->getDireccion(),
                'producto'=> $pedido->getProducto()->getNombre()
            );
        }

        return $response = array(
            'status' => "success",
            'pedidos' => $pedidosArray,
        );
    }

}