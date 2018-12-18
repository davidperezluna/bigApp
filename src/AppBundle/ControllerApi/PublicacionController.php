<?php

namespace AppBundle\ControllerApi;

use AppBundle\Entity\Categoria;
use AppBundle\Entity\Publicacion;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Publicacion controller.
 *
 */
class PublicacionController extends FOSRestController
{
    /**
     * @Rest\Post("/publicacion/imagen")
     */
    public function postPublicacionImagenAction(Request $request)
    { 
        
        $em = $this->getDoctrine()->getManager();

        $imagen = $request->files->get("ionicfile");

        $contenido = $request->request->get("contenido");
        $usuarioEmisor = $request->request->get("emisor");
        $usuarioReceptor = $request->request->get("receptor");

        $receptor = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($usuarioReceptor);
        $emisor = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($usuarioEmisor);

        $publicacion = new Publicacion();
        $fechaHoy = new \DateTime("now");
        $publicacion->setUsuarioEmisor($emisor);
        $publicacion->setUsuarioReceptor($receptor);
        $publicacion->setActivo(true);
        $publicacion->setContenido($contenido);
        $publicacion->setCreatedAt($fechaHoy);
        $publicacion->setUrlVideoYutube(null);

        $urlImagenName =  md5(uniqid()).'.'.$imagen->guessExtension();
        $imagen->move(
            $this->getParameter('imagen_publicacion_directory'),
            $urlImagenName
        );

        $publicacion->setImagen($urlImagenName);

        $em->persist($publicacion);
        $em->flush(); 

        return $response = array(
            'status' => "success",
            'datos' => $urlImagenName,
        );
    }


     /**
     * @Rest\Post("/publicacion/video")
     */
    public function postPublicacionVideoAction(Request $request)
    { 
        
        $em = $this->getDoctrine()->getManager();
        $data = $request->getContent();
        $params = json_decode($data);

        $video = $params->urlYoutube;

        $contenido = $params->contenido;
        $usuarioEmisor = $params->usuarioEmisor;
        $usuarioReceptor = $params->usuarioReceptor;

        $receptor = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($usuarioReceptor);
        $emisor = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($usuarioEmisor);

        $publicacion = new Publicacion();
        $fechaHoy = new \DateTime("now");
        $publicacion->setUsuarioEmisor($emisor);
        $publicacion->setUsuarioReceptor($receptor);
        $publicacion->setActivo(true);
        $publicacion->setContenido($contenido);
        $publicacion->setCreatedAt($fechaHoy);
        $video = str_replace("https://youtu.be/", "", $video);

        $publicacion->setUrlVideoYutube($video);

        $publicacion->setImagen(null);

        $em->persist($publicacion);
        $em->flush(); 

        return $response = array(
            'status' => "success",
        );
    }


     /**
     * @Rest\Post("/publicacion/text")
     */
    public function postPublicacionTextAction(Request $request)
    { 
        
        $em = $this->getDoctrine()->getManager();
        $data = $request->getContent();
        $params = json_decode($data);

        $contenido = $params->contenido;
        $usuarioEmisor = $params->usuarioEmisor;
        $usuarioReceptor = $params->usuarioReceptor;

        $receptor = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($usuarioReceptor);
        $emisor = $em->getRepository('MappsUsuarioBundle:User')->findOneByUsername($usuarioEmisor);

        $publicacion = new Publicacion();
        $fechaHoy = new \DateTime("now");
        $publicacion->setUsuarioEmisor($emisor);
        $publicacion->setUsuarioReceptor($receptor);
        $publicacion->setActivo(true);
        $publicacion->setContenido($contenido);
        $publicacion->setCreatedAt($fechaHoy);

        $publicacion->setUrlVideoYutube(null);

        $publicacion->setImagen(null);

        $em->persist($publicacion);
        $em->flush(); 

        return $response = array(
            'status' => "success",
        );
    }

}