<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Publicacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Publicacion controller.
 *
 * @Route("publicacion")
 */
class PublicacionController extends Controller
{
    /**
     * Lists all publicacion entities.
     *
     * @Route("/", name="publicacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publicacions = $em->getRepository('AppBundle:Publicacion')->findAll();

        return $this->render('AppBundle:publicacion:index.html.twig', array(
            'publicacions' => $publicacions,
        ));
    }

    /**
     * Creates a new publicacion entity.
     *
     * @Route("/new/{receptorId}/{emisorId}", name="publicacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $receptorId, $emisorId)
    {
        $em = $this->getDoctrine()->getManager();
        $publicacion = new Publicacion();
        $form = $this->createForm('AppBundle\Form\PublicacionType', $publicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $urlImagen = $publicacion->getImagen();

            if ($urlImagen != null) {
             if( $urlImagen->getSize() > 8000000 ) {
              $this->addFlash(
                  'notice',
                  'Tamaño de imagen excedido el tamaño debe ser de 10 mb maximo!'
              );
             return $this->redirectToRoute('homepage');
            }

            if ($urlImagen->guessExtension() != "jpg" and  $urlImagen->guessExtension() != "png" and  $urlImagen->guessExtension() != "jpeg") {
              $this->addFlash(
                  'notice',
                  'solo se Admiten los Formatos jpg, jpeg y png!'
              );
              return $this->redirectToRoute('homepage');
            }else{
              $urlImagenName = md5(uniqid()).'.'.$urlImagen->guessExtension();

              $urlImagen->move(
                  $this->getParameter('imagen_publicacion_directory'),
                  $urlImagenName
              );
              $publicacion->setImagen($urlImagenName);
            }  
            }
            

            $receptor = $em->getRepository('MappsUsuarioBundle:User')->find($receptorId);
            $emisor = $em->getRepository('MappsUsuarioBundle:User')->find($emisorId);

            $publicacion->setUsuarioEmisor($emisor);
            $publicacion->setUsuarioReceptor($receptor);
            $publicacion->setActivo(true);

            $urlVideo = $publicacion->getUrlVideoyutube();
            $urlVideo = str_replace("https://www.youtube.com/watch?v=", "", $urlVideo);

            $publicacion->setUrlVideoYutube($urlVideo);
            $em->persist($publicacion);
            $em->flush(); 

            return $this->redirectToRoute('perfil', array('id' => $receptor->getId()));
        }

        return $this->render('AppBundle:publicacion:new.html.twig', array(
            'publicacion' => $publicacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a publicacion entity.
     *
     * @Route("/{id}", name="publicacion_show")
     * @Method("GET")
     */
    public function showAction(Publicacion $publicacion)
    {
        $deleteForm = $this->createDeleteForm($publicacion);

        return $this->render('AppBundle:publicacion:show.html.twig', array(
            'publicacion' => $publicacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing publicacion entity.
     *
     * @Route("/{id}/edit", name="publicacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Publicacion $publicacion)
    {
        $deleteForm = $this->createDeleteForm($publicacion);
        $editForm = $this->createForm('AppBundle\Form\PublicacionType', $publicacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publicacion_edit', array('id' => $publicacion->getId()));
        }

        return $this->render('AppBundle:publicacion:edit.html.twig', array(
            'publicacion' => $publicacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a publicacion entity.
     *
     * @Route("/{id}", name="publicacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Publicacion $publicacion)
    {
        $form = $this->createDeleteForm($publicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($publicacion);
            $em->flush();
        }

        return $this->redirectToRoute('publicacion_index');
    }

    /**
     * Creates a form to delete a publicacion entity.
     *
     * @param Publicacion $publicacion The publicacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publicacion $publicacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publicacion_delete', array('id' => $publicacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
