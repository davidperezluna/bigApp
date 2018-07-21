<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProductoPromocion;
use AppBundle\Entity\BanerPublicidad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Productopromocion controller.
 *
 * @Route("productopromocion")
 */
class productoPromocionController extends Controller
{
    /**
     * Lists all productoPromocion entities.
     *
     * @Route("/", name="productopromocion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $productoPromocions = $em->getRepository('AppBundle:productoPromocion')->findAll();

        return $this->render('AppBundle:productopromocion:index.html.twig', array(
            'productoPromocions' => $productoPromocions,
        ));
    }

    /**
     * Creates a new productoPromocion entity.
     *
     * @Route("/new/{id}", name="productopromocion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, BanerPublicidad $banerPublicidad)
    {
        $em = $this->getDoctrine()->getManager();
        $productoPromocion = new Productopromocion();
        $form = $this->createForm('AppBundle\Form\productoPromocionType', $productoPromocion);
        $form->handleRequest($request);

         $productosEmpresa = $em->getRepository('AppBundle:Producto')->findByEmpresa($banerPublicidad->getEmpresa()->getId());


        if ($form->isSubmitted() && $form->isValid()) {

            $productosPromocion = $request->request->get("productos");

            
            foreach ($productosPromocion as $key => $pp) {
                $productoPromocion = new Productopromocion();
                $producto = $em->getRepository('AppBundle:Producto')->find($pp);

                $productoPromocion->setProducto($producto);
                $productoPromocion->setBanerPublicidad($banerPublicidad);


                $em->persist($productoPromocion);
                $em->flush();
            }
            

            return $this->redirectToRoute('productopromocion_show', array('id' => $productoPromocion->getId()));
        }

        return $this->render('AppBundle:productopromocion:new.html.twig', array(
            'productosEmpresa' => $productosEmpresa,
            'productoPromocion' => $productoPromocion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a productoPromocion entity.
     *
     * @Route("/{id}", name="productopromocion_show")
     * @Method("GET")
     */
    public function showAction(productoPromocion $productoPromocion)
    {
        $deleteForm = $this->createDeleteForm($productoPromocion);

        return $this->render('AppBundle:productopromocion:show.html.twig', array(
            'productoPromocion' => $productoPromocion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing productoPromocion entity.
     *
     * @Route("/{id}/edit", name="productopromocion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, productoPromocion $productoPromocion)
    {
        $deleteForm = $this->createDeleteForm($productoPromocion);
        $editForm = $this->createForm('AppBundle\Form\productoPromocionType', $productoPromocion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('productopromocion_edit', array('id' => $productoPromocion->getId()));
        }

        return $this->render('AppBundle:productopromocion:edit.html.twig', array(
            'productoPromocion' => $productoPromocion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a productoPromocion entity.
     *
     * @Route("/delete/{id}", name="productopromocion_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, productoPromocion $productoPromocion)
    {
      
            $em = $this->getDoctrine()->getManager();
            $em->remove($productoPromocion);
            $em->flush();

        return $this->redirectToRoute('banerpublicidad_show', array('id' => $productoPromocion->getBanerPublicidad()->getId()));
    }

    /**
     * Creates a form to delete a productoPromocion entity.
     *
     * @param productoPromocion $productoPromocion The productoPromocion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(productoPromocion $productoPromocion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productopromocion_delete', array('id' => $productoPromocion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
