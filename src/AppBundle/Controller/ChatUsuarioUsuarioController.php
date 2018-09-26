<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ChatUsuarioUsuario;
use MappsUsuarioBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Chatusuariousuario controller.
 *
 * @Route("chatusuariousuario")
 */
class ChatUsuarioUsuarioController extends Controller
{
    /**
     * Lists all chatUsuarioUsuario entities.
     *
     * @Route("/", name="chatusuariousuario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $chatUsuarioUsuarios = $em->getRepository('AppBundle:ChatUsuarioUsuario')->findAll();

        return $this->render('AppBundle:chatusuariousuario:index.html.twig', array(
            'chatUsuarioUsuarios' => $chatUsuarioUsuarios,
        ));
    }

    /**
     * Creates a new chatUsuarioUsuario entity.
     *
     * @Route("/{id}/new", name="chatusuariousuario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $direccion = $em->getRepository('MappsUsuarioBundle:User')->find($id);
        $chats = $em->getRepository('AppBundle:ChatUsuarioUsuario')->findComentariosNoVistosPorUsuario($direccion,$usuario);
        return $this->render('AppBundle:chatusuariousuario:new.html.twig', array(
            'direccion' => $direccion,
            'chats' => $chats,
        ));
    }

    /**
     * Finds and displays a chatUsuarioUsuario entity.
     *
     * @Route("/{id}", name="chatusuariousuario_show")
     * @Method("GET")
     */
    public function showAction(ChatUsuarioUsuario $chatUsuarioUsuario)
    {
        $deleteForm = $this->createDeleteForm($chatUsuarioUsuario);

        return $this->render('AppBundle:chatusuariousuario:show.html.twig', array(
            'chatUsuarioUsuario' => $chatUsuarioUsuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing chatUsuarioUsuario entity.
     *
     * @Route("/{id}/edit", name="chatusuariousuario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ChatUsuarioUsuario $chatUsuarioUsuario)
    {
        $deleteForm = $this->createDeleteForm($chatUsuarioUsuario);
        $editForm = $this->createForm('AppBundle\Form\ChatUsuarioUsuarioType', $chatUsuarioUsuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chatusuariousuario_edit', array('id' => $chatUsuarioUsuario->getId()));
        }

        return $this->render('AppBundle:chatusuariousuario:edit.html.twig', array(
            'chatUsuarioUsuario' => $chatUsuarioUsuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a chatUsuarioUsuario entity.
     *
     * @Route("/{id}", name="chatusuariousuario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ChatUsuarioUsuario $chatUsuarioUsuario)
    {
        $form = $this->createDeleteForm($chatUsuarioUsuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($chatUsuarioUsuario);
            $em->flush();
        }

        return $this->redirectToRoute('chatusuariousuario_index');
    }

    /**
     * Creates a form to delete a chatUsuarioUsuario entity.
     *
     * @param ChatUsuarioUsuario $chatUsuarioUsuario The chatUsuarioUsuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ChatUsuarioUsuario $chatUsuarioUsuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('chatusuariousuario_delete', array('id' => $chatUsuarioUsuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all chatUsuarioUsuario entities.
     *
     * @Route("/registrar/mensajes/{id}", name="registrar_mensajes")
     * @Method("GET")
     */
    public function guardarChatAction(Request $request,$id)
    {
    

      $mensaje = $request->query->get("mensaje");
      $fecha = new \DateTime('now');
      $em = $this->getDoctrine()->getManager();
      $direccion = $em->getRepository('MappsUsuarioBundle:User')->find($id);
        $chatUsuarioUsuario = new Chatusuariousuario();
        $chatUsuarioUsuario->setUsuario($this->getUser());
        $chatUsuarioUsuario->setMensaje($mensaje);
        $chatUsuarioUsuario->setDireccion($direccion);
        $chatUsuarioUsuario->setVisto(false);
        $chatUsuarioUsuario->setCreatedAt($fecha);
        $em->persist($chatUsuarioUsuario);
        $em->flush($chatUsuarioUsuario);
        $respuesta =  array('status' => true );
        $response = new Response();
        $response->setContent(json_encode($respuesta));

     return $response;
    }
}
