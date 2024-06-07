<?php
namespace App\Controller\Visitor\Registration;



use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private EntityManagerInterface $entityManager;

    public function __construct(EmailVerifier $emailVerifier, EntityManagerInterface $entityManager)
    {
        $this->emailVerifier = $emailVerifier;
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'visitor_registration_register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // encodage du mot de passe
           $passwordHashed =  $userPasswordHasher->hashPassword($user,$form->get('password')->getData());

            //  Initialisation de la propriété password avec le mot de passe encodé
            $user->setPassword($passwordHashed);
            $user->setCreatedAt(new DateTimeImmutable());
            $user->setUpdatedAt(new DateTimeImmutable());

            // Insérons les données en base
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('visitor_registration_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('chaussure-chic@gmail.com', 'chaussure-chic'))
                    ->to($user->getEmail())
                    ->subject('Veuillez valider votre compte')
                    ->htmlTemplate('pages/visitor/emails/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email

            return $this->redirectToRoute('visitor_registration_waiting_for_email_verification');
        }

        return $this->render('pages/visitor/registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }


    #[Route('/register/waiting-for-email-verification', name: 'visitor_registration_waiting_for_email_verification', methods :['GET'])]
    public function waitingForEmailVerification(): Response
    {
       return $this->render('pages/visitor/registration/waiting_for_email_verification.html.twig');
    }

    #[Route('/verify/email', name: 'visitor_registration_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UserRepository $userRepository): Response
    {
        //récuperation de l'id de l'utilisateur
        $id = $request->query->get('id');

        //on rentre dans la condition si l'utilisateur existe on le redirige vers la page d'inscription
        if (null === $id) {
            return $this->redirectToRoute('visitor_registration_register');
        }

        $user = $userRepository->find($id);

        //si l'utilisateur n'existe pas on le redirige vers la page d'inscription
        if (null === $user) {
            return $this->redirectToRoute('visitor_registration_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('visitor_registration_register');
        }

        $user->setVerifiedAt(new DateTimeImmutable());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre compte a bien été vérifié, vous pouvez vous connecter.');

        return $this->redirectToRoute('visitor_registration_register');
    }
}
