<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Amigo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Amigo controller.
 *
 * @Route("amigo")
 */
class AmigoController extends Controller
{
    /**
     * Lists all amigo entities.
     *
     * @Route("/", name="amigo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $amigos = $em->getRepository('AppBundle:Amigo')->findAll();

        return $this->render('amigo/index.html.twig', array(
            'amigos' => $amigos,
        ));
    }

    /**
     * Creates a new amigo entity.
     *
     * @Route("/new/{amigoId}", name="amigo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,$amigoId)
    {
        $em = $this->getDoctrine()->getManager();
        $usuarioAmigo = $em->getRepository('MappsUsuarioBundle:User')->find($amigoId);
        $usuario = $this->getUser();

        $amigo = new Amigo();
        $amigo->setAmigo($usuarioAmigo);
        $amigo->setUsuario($usuario);

        $em->persist($amigo);
        $em->flush();

        return $this->redirectToRoute('amigo_show', array('id' => $amigo->getId()));
    }

    /**
     * Finds and displays a amigo entity.
     *
     * @Route("/{id}", name="amigo_show")
     * @Method("GET")
     */
    public function showAction(Amigo $amigo)
    {
        $deleteForm = $this->createDeleteForm($amigo);

        return $this->render('amigo/show.html.twig', array(
            'amigo' => $amigo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing amigo entity.
     *
     * @Route("/{id}/edit", name="amigo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Amigo $amigo)
    {
        $deleteForm = $this->createDeleteForm($amigo);
        $editForm = $this->createForm('AppBundle\Form\AmigoType', $amigo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('amigo_edit', array('id' => $amigo->getId()));
        }

        return $this->render('amigo/edit.html.twig', array(
            'amigo' => $amigo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a amigo entity.
     *
     * @Route("/{id}", name="amigo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Amigo $amigo)
    {
        $form = $this->createDeleteForm($amigo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($amigo);
            $em->flush();
        }

        return $this->redirectToRoute('amigo_index');
    }

    /**
     * Creates a form to delete a amigo entity.
     *
     * @param Amigo $amigo The amigo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Amigo $amigo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('amigo_delete', array('id' => $amigo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
