<?php

namespace App\Controller\Visitor\Order;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderConrollerController extends AbstractController
{
    #[Route('/order', name: 'app_order_index', methods : ['GET'])]
    public function index(): Response
    {
        //recuperont l'utilisateur acutellement connecté
        /** @var User */
        $user= $this->getUser();

        //2 verifier si cet utilisteur a enregistré au moins une adresse de livraison

        if(\count($user->getAddresses()->toArray()) == 0)
        {
            $this->addFlash("warning","Vous devez enregistrer au moins une adresse de livraison avant de passer une commande");
           return $this->redirectToRoute('user_address_index');
        }
        return $this->render('pages/visitor/order/index.html.twig');
    }
}
