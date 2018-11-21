<?php

namespace Mapps\UsuarioBundle\Controller;

use Mapps\UsuarioBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('MappsUsuarioBundle:User')->findAll();

        return $this->render('MappsUsuarioBundle:user:index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('Mapps\UsuarioBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $factory = $this->get("security.encoder_factory");
            $encoder = $factory->getEncoder($user);
            $passwordd =$user->getPassword();
            $password = $encoder->encodePassword($passwordd, $user->getSalt());
            $user->setPassword($password);
            $user->setUsername($user->getEmail());
            $user->setFotoPerfil("user.png");
            $user->setFotoPortada("portadaDefault.jpg");

            $user->setEnabled(0);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("/login");
        }

        return $this->render('MappsUsuarioBundle:user:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new/app", name="user_new_app")
     * @Method({"GET", "POST"})
     */
    public function newAppAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('Mapps\UsuarioBundle\Form\UserAppType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $factory = $this->get("security.encoder_factory");
            $encoder = $factory->getEncoder($user);
            $passwordd =$user->getPassword();
            $password = $encoder->encodePassword($passwordd, $user->getSalt());
            $user->setPassword($password);
            $user->setUsername($user->getEmail());
            $user->setFotoPerfil("user.png");
            $user->setFotoPortada("portadaDefault.jpg");
            $em->persist($user);
            $em->flush();
            $user->setEnabled(0);
            $em->flush();

            return $this->redirectToRoute("user_confirmation");
        }

        return $this->render('MappsUsuarioBundle:user:new.app.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('MappsUsuarioBundle:user:show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('Mapps\UsuarioBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $factory = $this->get("security.encoder_factory");
            $encoder = $factory->getEncoder($user);
            $passwordd =$user->getPassword();
            $password = $encoder->encodePassword($passwordd, $user->getSalt());
            $user->setPassword($password);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('MappsUsuarioBundle:user:edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}/baneo/usuario", name="user_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, User $user)
    {
        
        $em = $this->getDoctrine()->getManager();

        if($user->isEnabled()){
            $user->setEnabled(false);
        }else{
            $user->setEnabled(true);
        }
        
        $em->flush();

        return $this->redirectToRoute('user_index');
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/confirmacion/", name="user_confirmation")
     * @Method("GET")
     */
    public function confirmationAction(Request $request)
    {
        return $this->render('MappsUsuarioBundle:user:confirmacion.html.twig');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
