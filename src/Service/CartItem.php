<?php 

namespace App\Service;

use App\Entity\Product;

class CartItem
{
    public function __construct(public Product $product, public int $quantity)
    {
    }
    //methode pour avoir le montant total de chaque produit du panier
    public function getAmount() : float
    {
      return  $this->product->getSellingPrice() * $this->quantity;
    }

}