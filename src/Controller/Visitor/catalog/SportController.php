<?php

namespace App\Controller\Visitor\catalog;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SportController extends AbstractController
{
    #[Route('/sport', name: 'visitor_sport_index')]
    public function index(): Response
    {
        return $this->render('pages/visitor/catalog/sport/index.html.twig');
    }
}
