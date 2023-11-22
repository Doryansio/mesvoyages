<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of VoyagesController
 *
 * @author Doryan
 */
class VoyagesController extends AbstractController{
    /**
     * @Route("/voyages", name="voyages")
     * @return Response
     */
    public function index(): Response{
        return $this->render("pages/voyages.html.twig");
    }
}