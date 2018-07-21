<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ImagenEmpresa;
use AppBundle\Entity\Empresa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Imagenempresa controller.
 *
 * @Route("imagenempresa")
 */
class ImagenEmpresaController extends Controller
{
    /**
     * Lists all imagenEmpresa entities.
     *
     * @Route("/", name="imagenempresa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imagenEmpresas = $em->getRepository('AppBundle:ImagenEmpresa')->findAll();

        return $this->render('AppBundle:imagenempresa:index.html.twig', array(
            'imagenEmpresas' => $imagenEmpresas,
        ));
    }

    /**
     * Creates a new imagenEmpresa entity.
     *
     * @Route("/new/{id}", name="imagenempresa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Empresa $empresa)
    {
        $imagenEmpresa = new Imagenempresa();
        $form = $this->createForm('AppBundle\Form\ImagenEmpresaType', $imagenEmpresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $urlImagen = $imagenEmpresa->getUrlImagen();
            if( $urlImagen->getSize() > 8000000 ) {
              $this->addFlash(
                  'notice',
                  'Tamaño de imagen excedido el tamaño debe ser de 10 mb maximo!'
              );
             return $this->redirectToRoute('imagenempresa_new');
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
                  $this->getParameter('imagen_empresa_directory'),
                  $urlImagenName
              );
              $imagenEmpresa->setUrlImagen($urlImagenName);
            }

            $imagenEmpresa->setEmpresa($empresa);

            $em = $this->getDoctrine()->getManager();
            $em->persist($imagenEmpresa);
            $em->flush();

            return $this->redirectToRoute('empresa_show', array('id' => $imagenEmpresa->getEmpresa()->getId()));
        }

        return $this->render('AppBundle:imagenempresa:new.html.twig', array(
            'imagenEmpresa' => $imagenEmpresa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a imagenEmpresa entity.
     *
     * @Route("/{id}", name="imagenempresa_show")
     * @Method("GET")
     */
    public function showAction(ImagenEmpresa $imagenEmpresa)
    {
        $deleteForm = $this->createDeleteForm($imagenEmpresa);

        return $this->render('AppBundle:imagenempresa:show.html.twig', array(
            'imagenEmpresa' => $imagenEmpresa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing imagenEmpresa entity.
     *
     * @Route("/{id}/edit", name="imagenempresa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImagenEmpresa $imagenEmpresa)
    {
        $deleteForm = $this->createDeleteForm($imagenEmpresa);
        $editForm = $this->createForm('AppBundle\Form\ImagenEmpresaType', $imagenEmpresa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('imagenempresa_edit', array('id' => $imagenEmpresa->getId()));
        }

        return $this->render('AppBundle:imagenempresa:edit.html.twig', array(
            'imagenEmpresa' => $imagenEmpresa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a imagenEmpresa entity.
     *
     * @Route("delete/{id}", name="imagenempresa_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, ImagenEmpresa $imagenEmpresa)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($imagenEmpresa);
        $em->flush();
        return $this->redirectToRoute('empresa_show', array('id' => $imagenEmpresa->getEmpresa()->getId()));
    }

    /**
     * Creates a form to delete a imagenEmpresa entity.
     *
     * @param ImagenEmpresa $imagenEmpresa The imagenEmpresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImagenEmpresa $imagenEmpresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imagenempresa_delete', array('id' => $imagenEmpresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
