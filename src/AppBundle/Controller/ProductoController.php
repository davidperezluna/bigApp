<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Producto;
use AppBundle\Entity\ProductoImagen;
use AppBundle\Entity\Empresa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Producto controller.
 *
 * @Route("producto")
 */
class ProductoController extends Controller
{
    /**
     * Lists all producto entities.
     *
     * @Route("/", name="producto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $productos = $em->getRepository('AppBundle:Producto')->findAll();

        return $this->render('AppBundle:producto:index.html.twig', array(
            'productos' => $productos,
        ));
    } 

    /**
     * Lists all producto entities.
     *
     * @Route("/list", name="producto_list")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT p FROM AppBundle:Producto p";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );

        // parameters to template
        return $this->render('AppBundle:producto:list.html.twig', array('pagination' => $pagination));
    }

    /**
     * Lists all producto entities.
     *
     * @Route("/busqueda", name="productos_busqueda")
     * @Method("POST")
     */
    public function busqeudaAction(Request $request)
    {

        
        $busqueda = $request->request->get("stringBusqueda");

        $em = $this->get('doctrine.orm.entity_manager');
        $productos = $em->getRepository('AppBundle:Producto')->findProductosPorNombre($busqueda);

        // parameters to template
        return $this->render('AppBundle:producto:busqueda.html.twig', array(
            'pagination' => $productos,
        ));
    }

    /**
     * Creates a new producto entity.
     *
     * @Route("/new/{id}", name="producto_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Empresa $empresa)
    {
        $producto = new Producto();
        $productoImagen = new ProductoImagen();
        $form = $this->createForm('AppBundle\Form\ProductoType', $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dir = $this->get('kernel')->getRootDir().'/../web/uploads/producto/';
            
            $producto->setActivo(1);
            $producto->setEmpresa($empresa);
            $fecha = new \DateTime("now");
            $producto->setCreatedAt($fecha);
            $em = $this->getDoctrine()->getManager();
            $em->persist($producto);
            $productoImagen->setProducto($producto);
            $productoImagen->setImagen("default.jpg");
            $productoImagen->setUrlImagen($dir."default.jpg");
            $em->persist($productoImagen);
            $em->flush();

            return $this->redirectToRoute('empresa_show', array('id' => $producto->getEmpresa()->getId()));
        }

        return $this->render('AppBundle:producto:new.html.twig', array(
            'producto' => $producto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a producto entity.
     *
     * @Route("/{id}", name="producto_show")
     * @Method("GET")
     */
    public function showAction(Producto $producto)
    {
        $deleteForm = $this->createDeleteForm($producto);

        return $this->render('AppBundle:producto:show.html.twig', array(
            'producto' => $producto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing producto entity.
     *
     * @Route("/{id}/edit", name="producto_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Producto $producto)
    {
        $deleteForm = $this->createDeleteForm($producto);
        $editForm = $this->createForm('AppBundle\Form\ProductoType', $producto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('producto_edit', array('id' => $producto->getId()));
        }

        return $this->render('AppBundle:producto:edit.html.twig', array(
            'producto' => $producto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a producto entity.
     *
     * @Route("/delete/{id}", name="producto_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Producto $producto)
    {
        $em = $this->getDoctrine()->getManager();
        
        $imagenes = $em->getRepository('AppBundle:ProductoImagen')->findByProducto($producto->getId());
        foreach ($imagenes as $key => $imagen) {
            $em->remove($imagen);
            $em->flush();
        }

        $em->remove($producto);
        $em->flush();
       

        return $this->redirectToRoute('empresa_show', array('id' => $producto->getEmpresa()->getId()));
    }

    /**
     * Creates a form to delete a producto entity.
     *
     * @param Producto $producto The producto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Producto $producto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('producto_delete', array('id' => $producto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
