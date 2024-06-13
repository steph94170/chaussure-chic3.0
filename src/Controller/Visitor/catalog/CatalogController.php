<?php
namespace App\Controller\Visitor\catalog;


use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository)
    {
        
    }

    #[Route('/catalog/{slug}', name: 'visitor_chaussures_index')]
    public function category(Category $category, ProductRepository $productRepository): Response
    {
        $products = $productRepository->findBy(['category' => $category ]);
        return $this->render('pages/visitor/catalog/chaussures/index.html.twig', [
           'category' => $category,
           'products' => $products
        ]);
    }
    #[Route('/catalog/{id}/{slug}/show', name: 'visitor_catalog_product_show', methods:['GET'])]
    public function show(Product $product): Response

    {
        return $this->render('pages/visitor/catalog/chaussures/show.html.twig', [
            'product' => $product
         ]);
    }
}
