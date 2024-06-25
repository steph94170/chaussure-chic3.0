<?php

namespace App\Controller\Visitor\Payment;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//j'ai securisé la route dans le fichier security.yaml 
#[Route('/payment')]
class PaymentController extends AbstractController
{
    #[Route('/', name: 'app_payment_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/visitor/payment/index.html.twig');
    }
}
