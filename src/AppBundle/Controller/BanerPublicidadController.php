<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BanerPublicidad;
use AppBundle\Entity\Empresa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Banerpublicidad controller.
 *
 * @Route("banerpublicidad")
 */
class BanerPublicidadController extends Controller
{
    /**
     * Lists all banerPublicidad entities.
     *
     * @Route("/", name="banerpublicidad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $banerPublicidads = $em->getRepository('AppBundle:BanerPublicidad')->findAll();

        return $this->render('AppBundle:banerpublicidad:index.html.twig', array(
            'banerPublicidads' => $banerPublicidads,
        ));
    }

    /**
     * Creates a new banerPublicidad entity.
     *
     * @Route("/new/{id}", name="banerpublicidad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Empresa $empresa)
    {
        $banerPublicidad = new Banerpublicidad();
        $form = $this->createForm('AppBundle\Form\BanerPublicidadType', $banerPublicidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $urlImagen = $banerPublicidad->getUrl();
            if( $urlImagen->getSize() > 8000000 ) {
              $this->addFlash(
                  'notice',
                  'Tamaño de imagen excedido el tamaño debe ser de 10 mb maximo!'
              );
             return $this->redirectToRoute('banerpublicidad_new', array('id' => $empresa->getId()));
            }

            if ($urlImagen->guessExtension() != "jpg" and  $urlImagen->guessExtension() != "png" and  $urlImagen->guessExtension() != "jpeg") {
              $this->addFlash(
                  'notice',
                  'solo se Admiten los Formatos jpg, jpeg y png!'
              );
              return $this->redirectToRoute('empresa_new');
            }else{
              $urlImagenName = md5(uniqid()).'.'.$urlImagen->guessExtension();
              $urlImagen->move(
                  $this->getParameter('baner_publicidad_directory'),
                  $urlImagenName
              );
              $banerPublicidad->setUrl($urlImagenName);
            }

            $banerPublicidad->setEmpresa($empresa);
            $em->persist($banerPublicidad);
            $em->flush();

            return $this->redirectToRoute('banerpublicidad_show', array('id' => $banerPublicidad->getId()));
        }

        return $this->render('AppBundle:banerpublicidad:new.html.twig', array(
            'banerPublicidad' => $banerPublicidad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a banerPublicidad entity.
     *
     * @Route("/{id}", name="banerpublicidad_show")
     * @Method("GET")
     */
    public function showAction(BanerPublicidad $banerPublicidad)
    {
        $deleteForm = $this->createDeleteForm($banerPublicidad);

        return $this->render('AppBundle:banerpublicidad:show.html.twig', array(
            'banerPublicidad' => $banerPublicidad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing banerPublicidad entity.
     *
     * @Route("/{id}/edit", name="banerpublicidad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BanerPublicidad $banerPublicidad)
    {
        $deleteForm = $this->createDeleteForm($banerPublicidad);
        $editForm = $this->createForm('AppBundle\Form\BanerPublicidadType', $banerPublicidad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('banerpublicidad_edit', array('id' => $banerPublicidad->getId()));
        }

        return $this->render('AppBundle:banerpublicidad:edit.html.twig', array(
            'banerPublicidad' => $banerPublicidad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a banerPublicidad entity.
     *
     * @Route("/{id}", name="banerpublicidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BanerPublicidad $banerPublicidad)
    {
        $form = $this->createDeleteForm($banerPublicidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($banerPublicidad);
            $em->flush();
        }

        return $this->redirectToRoute('banerpublicidad_index');
    }

    /**
     * Creates a form to delete a banerPublicidad entity.
     *
     * @param BanerPublicidad $banerPublicidad The banerPublicidad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BanerPublicidad $banerPublicidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('banerpublicidad_delete', array('id' => $banerPublicidad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
