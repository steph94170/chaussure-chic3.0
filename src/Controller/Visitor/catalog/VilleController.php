<?php

namespace App\Controller\Visitor\catalog;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VilleController extends AbstractController
{
    #[Route('/ville', name: 'visitor_ville_index')]
    public function index(): Response
    {
        return $this->render('pages/visitor/catalog/ville/index.html.twig');
    }
}
