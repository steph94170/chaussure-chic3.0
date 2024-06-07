<?php

namespace App\Controller\Admin\Category;

use DateTimeImmutable;
use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin')]
class CategoryController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em, 
        private CategoryRepository $categoryRepository)
    {
    }
    
    #[Route('/category/list', name: 'admin_category_index', methods :['GET'])]
    public function index(): Response
    {
        return $this->render('pages/admin/category/index.html.twig', [
            "categories" => $this->categoryRepository->findAll()
        ]);
    }

    #[Route('/category/create', name: 'admin_category_create',  methods: ['GET','POST'])]
    public function create(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $category->setCreatedAt(new DateTimeImmutable());
            $category->setUpdatedAt(new DateTimeImmutable());

            $this->em->persist($category);
            $this->em->Flush();

            $this->addFlash("success", "La catégorie a été ajoutée avec succès.");

            return $this->redirectToRoute("admin_category_index");
        }

        return $this->render('pages/admin/category/create.html.twig', [
            "form" => $form,
            "form" => $form->createView()
        ]);
    }

    #[Route('/category/{id<\d+>}/edit', name: 'admin_category_edit',  methods: ['GET','PUT'])]
    public function edit(Category $category,Request $request): Response 
    {
        $form = $this->createForm(CategoryFormType::class, $category, [
            "method"=> "PUT"
        ]);

        $form->handleRequest($request);
        if( $form->isSubmitted()&& $form->isValid())
        {
            $category->setUpdatedAt(new DateTimeImmutable());

            $this->em->persist($category);
            $this->em->Flush();

            $this->addFlash("success", "La catégorie a été modifiée avec succès.");

            return $this->redirectToRoute("admin_category_index");
        }

        return $this->render("pages/admin/category/edit.html.twig", [
            "category" => $category,
            "form"=> $form->createView()
        ]);
    }

    #[Route('/category/{id<\d+>}/delete', name: 'admin_category_delete', methods:['POST'])]
    public function delete(Category $category, Request $request): Response
    {
        
       
        if ($this->isCsrfTokenValid("delete_category_". $category->getId(), $request->request->get('crsf_token')))
        {
            $this->em->remove($category);
            $this->em->Flush();

            $this->addFlash("success", "La catégorie a été supprimée avec succès.");
        }

        return $this->redirectToRoute("admin_category_index");
    }
}

