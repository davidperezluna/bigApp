<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProductoImagen;
use AppBundle\Entity\Producto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Productoimagen controller.
 *
 * @Route("productoimagen")
 */
class ProductoImagenController extends Controller
{
    /**
     * Lists all productoImagen entities.
     *
     * @Route("/", name="productoimagen_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $productoImagens = $em->getRepository('AppBundle:ProductoImagen')->findAll();

        return $this->render('AppBundle:productoimagen:index.html.twig', array(
            'productoImagens' => $productoImagens,
        ));
    }

    /**
     * Creates a new productoImagen entity.
     *
     * @Route("/new/{id}", name="productoimagen_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Producto $producto)
    {
        $productoImagen = new Productoimagen();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('AppBundle\Form\ProductoImagenType', $productoImagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productoImagens = $em->getRepository('AppBundle:ProductoImagen')->findByProducto($producto->getId());
            
                foreach ($productoImagens as $key => $productoImagenDelete) {
                    if ($productoImagenDelete->getImagen()=="default.jpg") {
                        $em->remove($productoImagenDelete);
                        $em->flush();
                    }
                }

            $urlImagen = $productoImagen->getImagen();
            if( $urlImagen->getSize() > 8000000 ) {
              $this->addFlash(
                  'notice',
                  'Tamaño de imagen excedido el tamaño debe ser de 10 mb maximo!'
              );
            return $this->redirectToRoute('productoimagen_new', array('id' => $producto->getId()));
            }

            if ($urlImagen->guessExtension() != "jpg" and  $urlImagen->guessExtension() != "png" and  $urlImagen->guessExtension() != "jpeg") {
              $this->addFlash(
                  'notice',
                  'solo se Admiten los Formatos jpg, jpeg y png!'
              );
               return $this->redirectToRoute('productoimagen_new', array('id' => $producto->getId()));
            }else{
              $urlImagenName = md5(uniqid()).'.'.$urlImagen->guessExtension();
              $urlImagen->move(
                  $this->getParameter('imagen_producto_directory'),
                  $urlImagenName
              );
              $productoImagen->setImagen($urlImagenName);
              $productoImagen->setProducto($producto);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($productoImagen);
            $em->flush();

            return $this->redirectToRoute('producto_show', array('id' => $producto->getId()));
        }

        return $this->render('AppBundle:productoimagen:new.html.twig', array(
            'productoImagen' => $productoImagen,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a productoImagen entity.
     *
     * @Route("/{id}", name="productoimagen_show")
     * @Method("GET")
     */
    public function showAction(ProductoImagen $productoImagen)
    {
        $deleteForm = $this->createDeleteForm($productoImagen);

        return $this->render('AppBundle:productoimagen:show.html.twig', array(
            'productoImagen' => $productoImagen,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing productoImagen entity.
     *
     * @Route("/{id}/edit", name="productoimagen_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ProductoImagen $productoImagen)
    {
        $deleteForm = $this->createDeleteForm($productoImagen);
        $editForm = $this->createForm('AppBundle\Form\ProductoImagenType', $productoImagen);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('productoimagen_edit', array('id' => $productoImagen->getId()));
        }

        return $this->render('AppBundle:productoimagen:edit.html.twig', array(
            'productoImagen' => $productoImagen,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a productoImagen entity.
     *
     * @Route("/{id}", name="productoimagen_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ProductoImagen $productoImagen)
    {
        $form = $this->createDeleteForm($productoImagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($productoImagen);
            $em->flush();
        }

        return $this->redirectToRoute('productoimagen_index');
    }

    /**
     * Creates a form to delete a productoImagen entity.
     *
     * @param ProductoImagen $productoImagen The productoImagen entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProductoImagen $productoImagen)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productoimagen_delete', array('id' => $productoImagen->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
