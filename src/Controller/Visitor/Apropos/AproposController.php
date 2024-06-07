<?php

namespace App\Controller\Visitor\Apropos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AproposController extends AbstractController
{
    #[Route('/apropos', name: 'visitor_apropos_index')]
    public function index(): Response
    {
        return $this->render('pages/visitor/apropos/index.html.twig', [
            'controller_name' => 'AproposController',
        ]);
    }
}
