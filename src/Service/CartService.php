<?php
namespace App\Service;

use App\Service\CartItems;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    public function __construct(private RequestStack $requestStack, 
    private ProductRepository $productRepository )
    {
        
    }

    public function getCart(): array 
    {
      return $this->requestStack->getSession()->get('cart',[]);
    }

    public function setCart(array $cart) : self
    {
      $this->requestStack->getSession()->set('cart',$cart);
      return  $this;
    }

    public function add(int $id) : void
    {
        //recupérons le panier
        $cart = $this->getCart();

        //si le produit que je tente d'ajouter au panier existe deja 
        if (\array_key_exists($id,$cart))
        {
            //si le produit que je tente d'ajouter au panier existe deja alors incremente sa quantité de 1 
            $cart[$id]++;
        }
        else
        {
            //dans le cas contraire initialise sa quantité a 1 
            $cart[$id] = 1;
        }

        //mets a jour le panier
        $this->setcart($cart);
    }

    public function getCartItems(): array
    {
        //récuperer le panier
       $cart = $this->getCart();

       $cartItems = [];

       //en parcourant le tableau du panier
       //récuperons chaque produit correspondant à son identifiant
       //puis, sauvegardons ce produit ainsi que sa quantité dans le tableau des items

       foreach ($cart as $id => $quantity) 
       {
           $product = $this->productRepository->find($id);
           if ( null === $product)
           {
            continue;
           }
           $cartItems[] = new CartItem($product, $quantity);
       }
       return $cartItems;
    }
    public function getCartTotalAmount(): float
    {
        $cartItems = $this->getCartItems();

        $totalAmount =  0 ;
        foreach ($cartItems as $cartItem) 
        {
            $totalAmount += $cartItem->getAmount();
        }

        return $totalAmount;
    }

    public function decrement(int $id) :void
    {
        $cart = $this->getCart();

        //si le produit n'existe pas dans le panier on ne fait rien
        if (! \array_key_exists($id,$cart))
        {
            return;
        }

        // si le produit est egal a 1 il s'agit de retirer le produit du panier
        if ($cart[$id] == 1)
        {
            $this->remove($id);
            return;
        }
        // dans le cas contraire decrementer le produit de 1

        $cart[$id]--;
        $this->setCart($cart);
    }
    
    public function remove(int $id) :void
    {
        $cart = $this->getCart();

        unset($cart[$id]);

        $this->setCart($cart);
    }
    
}