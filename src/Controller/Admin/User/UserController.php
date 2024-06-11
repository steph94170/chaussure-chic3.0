<?php

namespace App\Controller\Admin\User;

use App\Entity\User;
use App\Form\EditRolesFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class UserController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/user/list', name: 'admin_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('pages/admin/user/index.html.twig', [
           "users"=> $userRepository->findAll()
        ]);
    }
    
    #[Route('/user/{id<\d+>}/edit-roles', name: 'admin_user_edit_roles', methods: ['GET', 'PUT'])]
    public function editRoles(User $user, Request $request) :Response
    {
        $form = $this->createForm(EditRolesFormType::class, $user, [
            "method" => "PUT"
        ] );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //requête de modification de l'utilisateur
            $this->em->persist($user);
            // exécution de la requête
            $this->em->Flush();
            $this->addFlash("success", "le role de {$user->getFirstName()} {$user->getLastName()} a été Modifié avec succès.");

            return $this->redirectToRoute("admin_user_index");
        }

        return $this->render('pages/admin/user/edit_roles.html.twig', [
            "form" => $form->createView()
         ]);
    }

    #[Route('/user/{id<\d+>}/delete', name: 'admin_user_delete', methods: ['POST'])]
    public function delete(User $user, Request $request) :Response
    {
        if ($this->isCsrfTokenValid("delete_user_". $user->getId(), $request->request->get('crsf_token')))
        {
           
            $this->addFlash("success", "le compte de {$user->getFirstName()} {$user->getLastName()} a été supprimé avec succès.");

            $this->em->remove($user);
            $this->em->Flush();

            
        }

        return $this->redirectToRoute("admin_user_index");
    }
}

