<?php

namespace App\Controller\Admin\Product;

use DateTimeImmutable;
use App\Entity\Product;
use App\Form\ProductFormType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class ProductController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em, 
        private CategoryRepository $categoryRepository)
    {
    }
    #[Route('/product/index', name: 'admin_product_index', methods:['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('pages/admin/product/index.html.twig', [
            "products" => $productRepository->findAll()
 
         ]);
    }
    #[Route('/product/create', name: 'admin_product_create', methods :['GET', 'POST'])]
    public function create(Request $request) :Response
    {
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $product->setCreatedAt(new DateTimeImmutable());
            $product->setUpdatedAt(new DateTimeImmutable());
    
            $product->setUser($this->getUser());

            $this->em->persist($product);
            $this->em->Flush();
            $this->addFlash("success", "le produit a été ajouté  avec succès.");

            return $this->redirectToRoute("admin_product_index");
        }

        return $this->render('pages/admin/product/create.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
