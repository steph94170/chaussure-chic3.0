<?php

namespace App\Controller\User\Order;

use App\Entity\Order;
use App\Form\EditOrderFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/user')]
class OrderController extends AbstractController
{
    public function __construct(  private EntityManagerInterface $em)
    {
        
    }
    #[Route('/order/list', name: 'user_order_index', methods : ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/user/order/index.html.twig');
    }

    #[Route('/order/{id<\d+>}/edit', name: 'user_order_edit', methods : ['GET','PUT'])]
    public function edit(Order $order,Request $request): Response
    {
        $form = $this->createForm(EditOrderFormType::class, $order, [
            "method" => "PUT"
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $order->setUser($this->getUser());
            
            $this->em->persist($order);
            $this->em->Flush();

            $this->addFlash("success", "La commande a été modifiée avec succès.");

            return $this->redirectToRoute("user_order_index");
        }

        return $this->render('pages/user/order/edit.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
