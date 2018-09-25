<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subasta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Subastum controller.
 *
 * @Route("subasta")
 */
class SubastaController extends Controller
{
    /**
     * Lists all subastum entities.
     *
     * @Route("/", name="subasta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $subastas = $em->getRepository('AppBundle:Subasta')->findAll();

        return $this->render('AppBundle:subasta:index.html.twig', array(
            'subastas' => $subastas,
        ));
    }

    /**
     * Creates a new subastum entity.
     *
     * @Route("/new", name="subasta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $subastum = new Subasta();
        $form = $this->createForm('AppBundle\Form\SubastaType', $subastum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fecha = new \DateTime('now');
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $productos = $em->getRepository('AppBundle:Producto')->findProductosPorNombre(
                $subastum->getPeticion(),
                $subastum->getMunicipio()->getId(),
                $subastum->getCategoria()->getId()
            );

            foreach ($productos as $key => $producto) {
                $subastumBd = new Subasta();
                $subastumBd->setCreatedAt($fecha);
                $subastumBd->setUsuario($user);
                $subastumBd->setProducto($producto);
                $subastumBd->setPeticion($subastum->getPeticion());
                $subastumBd->setMunicipio($subastum->getMunicipio());
                $em->persist($subastumBd);
                $em->flush();
            }
            

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:subasta:new.html.twig', array(
            'subastum' => $subastum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a subastum entity.
     *
     * @Route("/{id}", name="subasta_show")
     * @Method("GET")
     */
    public function showAction(Subasta $subastum)
    {
        $deleteForm = $this->createDeleteForm($subastum);

        $em = $this->getDoctrine()->getManager();

        $comentarios = $em->getRepository('AppBundle:SubastaComentario')->findBy(
            array(
                'subasta' => $subastum->getId()
            ), 
            array('fecha' => 'DESC'));


        return $this->render('AppBundle:subasta:show.html.twig', array(
            'subastum' => $subastum,
            'comentarios' => $comentarios,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing subastum entity.
     *
     * @Route("/{id}/edit", name="subasta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Subasta $subastum)
    {
        $deleteForm = $this->createDeleteForm($subastum);
        $editForm = $this->createForm('AppBundle\Form\SubastaType', $subastum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subasta_edit', array('id' => $subastum->getId()));
        }

        return $this->render('AppBundle:subasta:edit.html.twig', array(
            'subastum' => $subastum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a subastum entity.
     *
     * @Route("/delete/{id}", name="subasta_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Subasta $subastum)
    {
            $em = $this->getDoctrine()->getManager();
            $cometarios = $em->getRepository('AppBundle:SubastaComentario')->findBySubasta($subastum->getId());

            foreach ($cometarios as $key => $c) {
                $em->remove($c);

            }
            $em->remove($subastum);
            $em->flush();
        

        return $this->redirectToRoute('empresa_show', array('id' => $subastum->getProducto()->getEmpresa()->getId()));
    }

    /**
     * Creates a form to delete a subastum entity.
     *
     * @param Subasta $subastum The subastum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Subasta $subastum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subasta_delete', array('id' => $subastum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
