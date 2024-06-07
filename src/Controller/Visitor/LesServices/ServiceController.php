<?php
namespace App\Controller\Visitor\LesServices;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceController extends AbstractController
{
    #[Route('/lesService', name: 'visitor_lesServices_index')]
    public function index(): Response
    {
        return $this->render('pages/visitor/lesServices/index.html.twig');
    }
}
