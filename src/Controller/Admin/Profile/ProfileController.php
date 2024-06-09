<?php

namespace App\Controller\Admin\Profile;

use App\Entity\User;
use App\Form\EditProfileFormType;
use App\Form\EditPasswordFormType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin')]
class ProfileController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher)
    {
    }
    
    #[Route('/profile', name: 'admin_profile_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/admin/profile/index.html.twig');
    }

    #[Route('/profil/edit', name: 'admin_profile_edit', methods: ['GET', 'PUT'])]
    public function editProfile(Request $request): Response
    {
         /** @var User */
        $admin = $this->getUser();

        $form = $this->createForm(EditProfileFormType::class, $admin,[
            "method"=> "PUT"
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        { 
            $admin->setUpdatedAt(new DateTimeImmutable());

            $this->em->persist($admin);
            $this->em->Flush();

            $this->addFlash("success", "Le profile a été modifiée avec succès.");

            return $this->redirectToRoute("admin_profile_index");
        }

        return $this->render('pages/admin/profile/edit_profile.html.twig',[
            "form"=> $form->createView()
        ]);
    }

    #[Route('/profil/edit-password', name: 'admin_profile_edit_password', methods: ['GET', 'PUT'])]
    public function editPassword(Request $request): Response
    {
        /** @var User */
        $admin = $this->getUser();

        $form =  $this->createForm(EditPasswordFormType::class, null, [
            "method" => 'PUT'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        { 

            $plainPassword = $form->getData()['password'];
         
            $passwordHashed = $this->hasher->hashPassword($admin, $plainPassword);

            $admin->setPassword($passwordHashed);

            $admin->setUpdatedAt(new DateTimeImmutable());
           
            $this->em->persist($admin);
            $this->em->Flush();

            $this->addFlash("success", "Le mot de passe a été modifiée avec succès.");

            return $this->redirectToRoute("admin_profile_index");
        }

        return $this->render('pages/admin/profile/edit_password.html.twig',[
            "form"=> $form->createView()
        ]);
    }
}
