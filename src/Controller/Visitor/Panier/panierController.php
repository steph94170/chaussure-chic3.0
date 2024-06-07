<?php

namespace App\Controller\Visitor\Panier;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class panierController extends AbstractController
{
    #[Route('/panier', name: 'visitor_panier_index', methods : ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/visitor/panier/index.html.twig');
    }
}
