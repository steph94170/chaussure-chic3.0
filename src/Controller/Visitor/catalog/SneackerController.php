<?php
namespace App\Controller\Visitor\catalog;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SneackerController extends AbstractController
{
    #[Route('/sneacker', name: 'visitor_sneacker_index')]
    public function index(): Response
    {
        return $this->render('pages/visitor/catalog/sneacker/index.html.twig');
    }
}
