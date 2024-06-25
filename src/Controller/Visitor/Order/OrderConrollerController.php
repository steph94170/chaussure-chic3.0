<?php

namespace App\Controller\Visitor\Order;

use App\Form\OrderFormType;
use App\Service\CartService;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderConrollerController extends AbstractController
{

    public function __construct(
        private CartService $cartService,
        private OrderService $orderService,
    )
    {
        
    }

    #[Route('/order', name: 'app_order_index', methods : ['GET','POST'])]
    public function index(Request $request): Response
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


        //3 Vérifier si les données sont toujours dans le panier

        if (count($this-> cartService->getCartItems())<= 0)
        {
            $this->addFlash("warning","veuillez ajouter des produits au panier avant de passer une commande");
            return $this->redirectToRoute('user_cart_index');
        }
        //4 creation du formulaire de commande
        $form =$this->createForm(OrderFormType::class, null , [
            "user" => $user
        ]);

        //6 associons les donneés du formulaire a la requete
        $form->handleRequest($request);

        //7 Si le formulaire est soumis et valide je vais recupérer l'adresse et livreur
        if ($form->isSubmitted() && $form->isValid()) 
        {
           $address = $form->get('address')->getData();
           $carrier = $form->get('carrier')->getData();

           //test
            //dd($address, $carrier);

            $this->orderService->persist($address,$carrier);

           return $this->redirectToRoute('app_payment_index');
        }
        

        //5 passer a la vue
        return $this->render('pages/visitor/order/index.html.twig',[
            "form" => $form->createView(),
            "cartItems" => $this->cartService->getCartItems()
        ]);
    }
}
