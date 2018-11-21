<?php

namespace Mapps\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/" , name="homepage")
     */
    public function indexAction()
    {
 
        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository('AppBundle:Producto')->findBy(array(), array('id' => 'DESC'),3);
        $amigos = $em->getRepository('AppBundle:Amigo')->findBy(array(
            'usuario' => $this->getUser()->getId()
        ), array('id' => 'DESC'),3);

    	$user = $this->getUser();
        $peticiones = $em->getRepository('AppBundle:Subasta')->findByUsuario($user->getId());
        $numeroPeticiones = count($peticiones) -1;
        if ($peticiones) {
            $this->addFlash(
                'notice',
                'Uste tiene '.$numeroPeticiones.' nuevas peticiones de subasta!'
            );
        }

    	return $this->render('MappsUsuarioBundle:Default:index.html.twig', array(
            'productos' => $productos,
            'peticiones' => $peticiones,
            'amigos' => $amigos,
            'user' => $user,
        ));
        
    }

     /**
     * @Route("/perfil/{id}" , name="perfil")
     */
    public function perfilAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository('AppBundle:Producto')->findBy(array(), array('id' => 'DESC'),3);
        $amigos = $em->getRepository('AppBundle:Amigo')->findBy(array(
            'usuario' => $id
        ), array('id' => 'DESC'),3);

        $user = $em->getRepository('MappsUsuarioBundle:User')->find($id);
        
    	return $this->render('MappsUsuarioBundle:Default:index.html.twig', array(
            'productos' => $productos,
            'amigos' => $amigos,
            'user' => $user,
        ));
        
    }
}
