<?php

namespace Mapps\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/" , name="homepage")
     */
    public function indexAction()
    {
        return $this->render('MappsUsuarioBundle:Default:index.html.twig');
    }
}
