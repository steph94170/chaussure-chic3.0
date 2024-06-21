<?php

namespace App\Controller\Visitor\Panier;

use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class panierController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository, private CartService $cartService)
    {
        
    }
    #[Route('/panier', name: 'visitor_panier_index', methods : ['GET'])]
    public function index(): Response
    {
        $this->cartService->getCartItems();
        $this->cartService->getCartTotalAmount();
        return $this->render('pages/visitor/panier/index.html.twig',[
            "cartItems" => $this->cartService->getCartItems(),
            "cartTotalAmount" => $this->cartService->getCartTotalAmount(),
        ]);
    }

    #[Route('/panier/{id}/add', name: 'visitor_panier_add', methods : ['GET'])]
    public function add(string $id): Response
    {
         $product =  $this->productRepository->find((int)$id);
        if (null === $product)
        {
           throw $this->createNotFoundException("the product whit id={$id} not found");
        }
        if ($product->getQuantity()<= 0)
        {
           throw $this->createNotFoundException("the product whit id={$id} is not available");
        }
        $this->cartService->add((int) $id);

       return $this->redirectToRoute("visitor_panier_index");
    }
    #[Route('/panier/{id}/decrement', name: 'visitor_panier_decrement', methods : ['GET'])]
    public function decrement(string $id): Response
    {
        $product =  $this->productRepository->find((int)$id);
        if (null === $product)
        {
           throw $this->createNotFoundException("the product whit id={$id} not found");
        }
        if ($product->getQuantity()<= 0)
        {
           throw $this->createNotFoundException("the product whit id={$id} is not available");
        }
        $this->cartService->decrement((int)$id);

        return $this->redirectToRoute("visitor_panier_index");
    }
    #[Route('/panier/{id}/remove', name: 'visitor_panier_remove', methods : ['GET'])]
    public function remove(string $id): Response 
    {
        $product =  $this->productRepository->find((int)$id);
        if (null === $product)
        {
           throw $this->createNotFoundException("the product whit id={$id} not found");
        }
        if ($product->getQuantity()<= 0)
        {
           throw $this->createNotFoundException("the product whit id={$id} is not available");
        }
        $this->cartService->remove((int) $id);

       return $this->redirectToRoute("visitor_panier_index");
    }
}
