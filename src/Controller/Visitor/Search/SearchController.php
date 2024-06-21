<?php

namespace App\Controller\Visitor\Search;

use App\Service\SearchService;
use App\Form\SearchProductsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em)
    {
    }
    #[Route('/search', name: 'app_search', methods :['GET'])]
    public function index(Request $request, SearchService $searchService): Response
    {
        


        $form= $this->createForm(SearchProductsFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
           

            $data =$form->getData();
            dd($data);
            $products = $searchService->searchProducts($data['category'], $data['keywords']);

            dd($products);
        }
        
        return $this->render('visitor/search/search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function getSearchBar(): Response
    {
       $form= $this->createForm(SearchProductsFormType::class);

       return  $this->render("components/_search_bar.html.twig",[
        'form' => $form->createView(),
       ] );

    }
}
