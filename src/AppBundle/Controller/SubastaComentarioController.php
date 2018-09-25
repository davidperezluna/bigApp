<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SubastaComentario;
use AppBundle\Entity\Subasta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Subastacomentario controller.
 *
 * @Route("subastacomentario")
 */
class SubastaComentarioController extends Controller
{
    /**
     * Lists all subastaComentario entities.
     *
     * @Route("/", name="subastacomentario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $subastaComentarios = $em->getRepository('AppBundle:SubastaComentario')->findAll();

        return $this->render('subastacomentario/index.html.twig', array(
            'subastaComentarios' => $subastaComentarios,
        ));
    }

    /**
     * Creates a new subastaComentario entity.
     *
     * @Route("/new/{id}", name="subastacomentario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Subasta $subasta)
    {
        $subastaComentario = new Subastacomentario();
       
       
            $em = $this->getDoctrine()->getManager();

            $coontenido = $request->request->get("contenido");

            $subastaComentario->setFecha(new \DateTime("now"));
            $subastaComentario->setUsuarioEmisor($this->getUser());

            $subastaComentario->setSubasta($subasta);
            $subastaComentario->setContenido($coontenido);

            $em->persist($subastaComentario);
            $em->flush();

            return $this->redirectToRoute('subasta_show', array('id' => $subasta->getId()));
        
    }

    /**
     * Finds and displays a subastaComentario entity.
     *
     * @Route("/{id}", name="subastacomentario_show")
     * @Method("GET")
     */
    public function showAction(SubastaComentario $subastaComentario)
    {
        $deleteForm = $this->createDeleteForm($subastaComentario);

        return $this->render('subastacomentario/show.html.twig', array(
            'subastaComentario' => $subastaComentario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing subastaComentario entity.
     *
     * @Route("/{id}/edit", name="subastacomentario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SubastaComentario $subastaComentario)
    {
        $deleteForm = $this->createDeleteForm($subastaComentario);
        $editForm = $this->createForm('AppBundle\Form\SubastaComentarioType', $subastaComentario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subastacomentario_edit', array('id' => $subastaComentario->getId()));
        }

        return $this->render('subastacomentario/edit.html.twig', array(
            'subastaComentario' => $subastaComentario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a subastaComentario entity.
     *
     * @Route("/{id}", name="subastacomentario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SubastaComentario $subastaComentario)
    {
        $form = $this->createDeleteForm($subastaComentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subastaComentario);
            $em->flush();
        }

        return $this->redirectToRoute('subastacomentario_index');
    }

    /**
     * Creates a form to delete a subastaComentario entity.
     *
     * @param SubastaComentario $subastaComentario The subastaComentario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SubastaComentario $subastaComentario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subastacomentario_delete', array('id' => $subastaComentario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
