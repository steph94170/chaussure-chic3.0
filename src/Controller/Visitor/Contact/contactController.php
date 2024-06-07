<?php

namespace App\Controller\Visitor\Contact;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class contactController extends AbstractController
{
    #[Route('contact', name: 'visitor_contact_index')]
    public function index(): Response
    {
        return $this->render('pages/visitor/contact/index.html.twig');
    }
}
