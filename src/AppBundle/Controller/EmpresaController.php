<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Empresa;
use MappsUsuarioBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ThumbAndCrop;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Empresa controller.
 *
 * @Route("empresa")
 */
class EmpresaController extends Controller
{
  
    /**
     * Lists all empresa entities.
     *
     * @Route("/", name="empresa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if ($this->getUser()->getRolePersona() != "ROLE_ADMIN") {
          return $this->redirectToRoute('homepage');
        }else{
        $em = $this->getDoctrine()->getManager();

        $empresas = $em->getRepository('AppBundle:Empresa')->findAll();

        return $this->render('AppBundle:empresa:index.html.twig', array(
            'empresas' => $empresas,
        ));
      }
    }

    /**
     * Lists all empresas entities.
     *
     * @Route("/list", name="empresa_list")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT e FROM AppBundle:Empresa e";
        $query = $em->createQuery($dql);
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );

        // parameters to template
        return $this->render('AppBundle:empresa:list.html.twig', array(
            'pagination' => $pagination,
            'municipios' => $municipios
        ));
    }

    /**
     * Lists all producto entities.
     *
     * @Route("/busqueda", name="empresa_busqueda")
     * @Method("POST")
     */
    public function buscarEmpresaAction(Request $request)
    {

        
        $busqueda = $request->request->get("stringBusqueda");
        $municipioId = $request->request->get("municipioId");

        
        if ($municipioId == null) {
           $municipioId = 1;
        }
        $em = $this->get('doctrine.orm.entity_manager');
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();

        $empresas = $em->getRepository('AppBundle:Empresa')->finEmpresaNombre($busqueda,$municipioId);


        // parameters to template
        return $this->render('AppBundle:empresa:busqueda.html.twig', array(
            'municipios' => $municipios,
            'pagination' => $empresas
        ));
    }

    /**
     * Creates a new empresa entity.
     *
     * @Route("/new", name="empresa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $empresa = new Empresa();
        $form = $this->createForm('AppBundle\Form\EmpresaType', $empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fotoLogo = $empresa->getFotoLogo();
            $fotoPortada = $empresa->getFotoPortada();
 
            if( $fotoLogo->getSize() > 8000000 ) {
              $this->addFlash(
                  'notice',
                  'Tamaño de imagen excedido el tamaño debe ser de 10 mb maximo!'
              );
             return $this->redirectToRoute('empresa_new');
            }
             if( $fotoPortada->getSize() > 8000000 ) {
              $this->addFlash(
                  'notice',
                  'Tamaño de imagen excedido el tamaño debe ser de 10 mb maximo!'
              );
             return $this->redirectToRoute('empresa_new');
            }
              if ($fotoLogo->guessExtension() != "jpg" and  $fotoLogo->guessExtension() != "png" and  $fotoLogo->guessExtension() != "jpeg") {
                $this->addFlash(
                    'notice',
                    'solo se Admiten los Formatos jpg, jpeg y png!'
                );
                return $this->redirectToRoute('empresa_new');
              }else{
                $fotoLogoName = md5(uniqid()).$empresa->getNit().'.'.$fotoLogo->guessExtension();
                $fotoLogo->move(
                    $this->getParameter('logo_empresa_directory'),
                    $fotoLogoName
                );
                $empresa->setFotoLogo($fotoLogoName);
                $empresa->setUrlLogo($this->getParameter('logo_empresa_directory').$fotoLogoName);
              }

            $fotoPortada = $empresa->getFotoPortada();
            if ($fotoPortada->guessExtension() != "jpg" and  $fotoPortada->guessExtension() != "png" and  $fotoPortada->guessExtension() != "jpeg") {
              $this->addFlash(
                  'notice',
                  'solo se Admiten los Formatos jpg, jpeg y png!'
              );
              return $this->redirectToRoute('empresa_new');
            }else{
                $fotoPortadaName = md5(uniqid()).$empresa->getNit().'.'.$fotoPortada->guessExtension();

                $fotoPortada->move(
                    $this->getParameter('portada_empresa_directory'),
                    $fotoPortadaName
                );
                $empresa->setFotoPortada($fotoPortadaName);
                $empresa->setUrlPortada($this->getParameter('portada_empresa_directory').$fotoPortadaName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($empresa);
            $em->flush($empresa);

            return $this->redirectToRoute('empresa_index');
        }

        return $this->render('AppBundle:empresa:new.html.twig', array(
            'empresa' => $empresa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a empresa entity.
     *
     * @Route("/{id}", name="empresa_show")
     * @Method("GET")
     */
    public function showAction(Request $request,Empresa $empresa)
    {
      $em = $this->getDoctrine()->getManager();
      $subastas = $em->getRepository('AppBundle:Subasta')->findSubastaPorEmpresa($empresa->getId());
      $vistas = $empresa->getVisitas() + 1;
      $empresa->setVisitas($vistas);
      $em->flush($empresa);
     
      // parameters to template
      return $this->render('AppBundle:empresa:show.html.twig', array(
          'empresa'=>$empresa,
          'subastas'=>$subastas
        ));
    }

    /**
     * Displays a form to edit an existing empresa entity.
     *
     * @Route("/{id}/edit", name="empresa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Empresa $empresa)
    {
        $deleteForm = $this->createDeleteForm($empresa);
        $editForm = $this->createForm('AppBundle\Form\EmpresaType', $empresa);
        $editForm->handleRequest($request);

        $fotoLogoOld = $empresa->getFotoLogo();
        $fotoPortadaOld = $empresa->getFotoPortada();

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $fotoLogo = $empresa->getFotoLogo();
            $fotoPortada = $empresa->getFotoPortada();

            if ($fotoLogo != null) {
                if( $fotoLogo->getSize() > 8000000 ) {
                $this->addFlash(
                    'notice',
                    'Tamaño del Logo excedido el tamaño debe ser de 10 mb maximo!'
                );
               return $this->redirectToRoute('empresa_edit', array('id' => $empresa->getId()));
              }
            }
            if ($fotoPortada != null) {
              
               if( $fotoPortada->getSize() > 8000000 ) {
                $this->addFlash(
                    'notice',
                    'Tamaño de foto de portada excedido el tamaño debe ser de 10 mb maximo!'
                );
               return $this->redirectToRoute('empresa_edit', array('id' => $empresa->getId()));
              }
            }

            $fotoLogo = $empresa->getFotoLogo();
            if ($fotoLogo == null) {
              $fotoLogoName = $request->request->get("fotoLogoOld");

            }else{
              $fotoLogoName = md5(uniqid()).$empresa->getNit().'.'.$fotoLogo->guessExtension();
              $fotoLogo->move(
                  $this->getParameter('logo_empresa_directory'),
                  $fotoLogoName
              );
            }

            $fotoPortada = $empresa->getFotoPortada();
            if ($fotoPortada == null) {
                $fotoPortadaName = $request->request->get("fotoPortadaOld");

            }else{
              $fotoPortadaName = md5(uniqid()).$empresa->getNit().'.'.$fotoPortada->guessExtension();
              $fotoPortada->move(
                  $this->getParameter('portada_empresa_directory'),
                  $fotoPortadaName
              );
            }
            $empresa->setFotoPortada($fotoPortadaName);
            $empresa->setFotoPortadaCov("");
            $empresa->setFotoLogo($fotoLogoName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('empresa_show', array('id' => $empresa->getId()));
        }

        return $this->render('AppBundle:empresa:edit.html.twig', array(
            'empresa' => $empresa,
            'fotoLogoOld' => $fotoLogoOld,
            'fotoPortadaOld' => $fotoPortadaOld,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a empresa entity.
     *
     * @Route("/{id}", name="empresa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Empresa $empresa)
    {
        $form = $this->createDeleteForm($empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($empresa);
            $em->flush();
        }

        return $this->redirectToRoute('empresa_index');
    }

    /**
     * Creates a form to delete a empresa entity.
     *
     * @param Empresa $empresa The empresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Empresa $empresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('empresa_delete', array('id' => $empresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all empresa entities.
     *
     * @Route("/show/paginacion/anonimo/{id}", name="empresa_show_paginacion_anonimo")
     * @Method("GET")
     */

      public function showPaginacionAnonimoAction(Request $request,Empresa $empresa)
        {
          $em    = $this->getDoctrine()->getManager();
          $ban = false;
          $planEmpresa = $em->getRepository('AppBundle:PlanEmpresa')->findOneByEmpresa($empresa->getId());
                  $plan = $planEmpresa->getPlan();
                  $planesServicios = $plan->getPlanesServicios();

                  foreach ($planesServicios as $key => $ps) {
                    if ($ps->getServicio()->getNombre() == "Localizacion") {
                      $ban = true;
                    }
                  }
            $vistas = $empresa->getVisitas() + 1;
            $empresa->setVisitas($vistas);
            $em->flush($empresa);
            $planEmpresa = $em->getRepository('AppBundle:PlanEmpresa')->findOneByEmpresa($empresa->getId());
            $plan = $planEmpresa->getPlan();
            $planesServicios = $plan->getPlanesServicios();

            $productos = $em->getRepository('AppBundle:Producto')->findAll();
            $sectores = $em->getRepository('AppBundle:Sector')->findAll();
            // parameters to template
            return $this->render('AppBundle:empresa:show.anonimo.html.twig', array(
              'pagination' => $productos,
              'empresa'=>$empresa,
              'sectores' => $sectores,
              'planServicios' => $planesServicios,
              'ban'=>$ban,
              )
            );
        }

        /**
         * Lists all empresa entities.
         *
         * @Route("/empresa/cambiar/colores/{id}", name="empresa_cambiar_colores")
         * @Method("POST")
         */

          public function EmpresaCambiarColoresAction(Request $request,Empresa $empresa)
          {

              $em = $this->getDoctrine()->getManager();
              $empresa->setColorPrimario($request->request->get("colorPrimario"));
              $empresa->setColorSecundario($request->request->get("colorSecundario"));
              $em->flush($empresa);

              return $this->redirectToRoute('empresa_show_paginacion', array('id' => $empresa->getId()));

          }

          /**
           * Lists all empresa entities.
           *
           * @Route("/show/loacation/{id}", name="empresa_show_location")
           * @Method("GET")
           */
          public function showLocationAction(Empresa $empresa){
              return $this->render('AppBundle:empresa:show.location.html.twig',
                array(
                  'empresa'=>$empresa,
                )
              );

          }

          /**
           * Lists all empresa entities.
           *
           * @Route("/bar/char/json/{id}", name="bar_char_json")
           * @Method("GET")
           */
          public function barCharJsonAction(Empresa $empresa){
            $em = $this->getDoctrine()->getManager();
            $dql   =
            "SELECT pf, COUNT(pf.usuario) AS total  FROM AppBundle:ProductoFavorito pf
            JOIN pf.producto p
            JOIN p.empresa e
            WHERE e.id = :idEmpresa
            GROUP BY pf.producto
            ORDER BY total DESC
            ";
            $query = $em->createQuery($dql);
            $query->setParameter("idEmpresa", $empresa->getId());

            $productosFavoritos = $query->getResult();
            $productos = $em->getRepository('AppBundle:Producto')->findByEmpresa($empresa->getId());

            foreach ($productos as $key => $producto) {
                $productosArray[$key] = array(
                  'valor' => $producto->getValor() ,
                  'cantidad' => $producto->getCantidad() ,
              );
            }
            $response = new Response();
            $response->setContent(json_encode($productosArray));

            return $response;

          }

          /**
           * Creates a new empresa entity.
           *
           * @Route("/new/empresa/demo/{id}", name="empresa_new_demo")
           * @Method({"GET", "POST"})
           */
          public function newDemoAction(Request $request, User $usuario)
          {
              $empresa = new Empresa();

              $form = $this->createForm('AppBundle\Form\EmpresaType', $empresa);
              $form->handleRequest($request);

              if ($form->isSubmitted() && $form->isValid()) {
                  $fotoLogo = $empresa->getFotoLogo();
                  $fotoLogoName = md5(uniqid()).$empresa->getNit().'.'.$fotoLogo->guessExtension();
                  $fotoLogo->move(
                      $this->getParameter('logo_empresa_directory'),
                      $fotoLogoName
                  );
                  $fotoPortada = $empresa->getFotoPortada();
                  $fotoPortadaName = md5(uniqid()).$empresa->getNit().'.'.$fotoPortada->guessExtension();
                  $fotoPortada->move(
                      $this->getParameter('portada_empresa_directory'),
                      $fotoPortadaName
                  );
                  $empresa->setFotoPortada($fotoPortadaName);
                  $empresa->setFotoLogo($fotoLogoName);
                  $empresa->setUsuario($usuario);
                  $empresa->setFotoPortadaCov("");
                  $em = $this->getDoctrine()->getManager();
                  $em->persist($empresa);
                  $em->flush($empresa);

                  $planEmpresa = new PlanEmpresa();
                  $plan = $em->getRepository('AppBundle:Plan')->find(6);
                  $planEmpresa->setEmpresa($empresa);
                  $planEmpresa->setPlan($plan);
                  $planEmpresa->setActivo(0);

                  $em->persist($planEmpresa);
                  $em->flush($planEmpresa);

                  return $this->redirectToRoute('empresa_show_paginacion', array('id' => $empresa->getId()));
              }

              return $this->render('AppBundle:empresa:new.html.twig', array(
                  'empresa' => $empresa,
                  'form' => $form->createView(),
              ));
          }

          /**
           * Creates a new empresa entity.
           *
           * @Route("/recortar/imagen/{id}", name="reposicionar_imagen_empresa")
           * @Method({"GET", "POST"})
           */
          public function recortarImagen(Empresa $empresa){
            if(isset($_POST['pos']))
            {
              $from_top = abs($_POST['pos']);
              $default_cover_width = 1649.01;
              $default_cover_height = 800;
                // includo la classe
                // valorizzo la variabile
                $tb = new ThumbAndCrop;
                // apro l'immagine
                $tb->openImg($this->getParameter('portada_empresa_directory')."/".$empresa->getFotoPortada()); //original cover image
                $newHeight = $tb->getRightHeight($default_cover_width);
                $tb->creaThumb($default_cover_width, $newHeight);
              $tb->setThumbAsOriginal();
                $tb->cropThumb($default_cover_width, 800, 0, $from_top);
                $tb->saveThumb($this->getParameter('portada_empresa_directory')."/recortes/".$empresa->getFotoPortada()); //save cropped cover image
                $tb->resetOriginal();

              $em = $this->getDoctrine()->getManager();
              $empresa->setFotoPortadaCov($empresa->getFotoPortada());
              $em->flush($empresa);

              $data = new JsonResponse();
              $data->setData(array(
                  'status' => 200,
                  'url' => $empresa->getFotoPortada(),
              ));
              return($data);
            }
          }

          /**
           * Lists all empresa entities.
           *
           * @Route("/show/loacation/movil/{id}", name="empresa_show_location_movil")
           * @Method("GET")
           */
          public function showLocationMovilAction(Empresa $empresa){
              return $this->render('AppBundle:empresa:show.location.movil.html.twig',
                array(
                  'empresa'=>$empresa,
                )
              );

          }

        
}
