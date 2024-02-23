<?php
namespace App\Controller;

use App\Entity\User1;
use App\Form\UserType;
use App\Form\UpdateType;
use App\Repository\User1Repository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserController extends AbstractController
{
    #[Route('/register', name: 'user_register')]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,User1Repository $userRepository): Response
    {
        $user = new User1();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        try {
            // Vérifier si l'email est déjà utilisé
            $email = $request->request->get('Email');
            if ($userRepository->findBy(['Email' => $email])) {
                // Email déjà existant, renvoyer une réponse avec un message d'erreur
                throw new \Exception('An exception occurred while executing a query: SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '.$email.' for key "UNIQ_8C518555E7927C74"');
            }

            // Suite de votre code si aucune exception n'est levée
        } catch (\Exception $e) {
            // En cas d'exception, renvoyer une réponse JSON avec le message d'erreur
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_CONFLICT);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $form->get('password')->getData())
            );

            // Save the user to the database (you might want to add more checks here)
            $entityManager = $this->getDoctrine()->getManager();
            $selectedRoles = $form->get('roles')->getData();

            // Ensure the selected roles is an array
                        if (!is_array($selectedRoles)) {
                            // Handle the case where the roles are not an array
                            throw new \InvalidArgumentException('Invalid roles data.');
                        }
            
            // Set the roles with only the first element
            $user->setRoles($selectedRoles);
            // Persist and flush the changes
                        $entityManager->persist($user);
                        $entityManager->flush();
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirect to a success page or login
            return $this->redirectToRoute('app_login');
                }
        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/update', name: 'updateuser', methods: ['GET', 'POST'])]
    public function updateUser(Request $request, EntityManagerInterface $entityManager, Security $security, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $security->getUser();
    
        // Ensure the user is authenticated
        if (!$user instanceof User1) {
            throw $this->createAccessDeniedException('User is not authenticated.');
        }
    
        $form = $this->createForm(UpdateType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('password')->getData()) {
                $user->setPassword(
                    $passwordEncoder->encodePassword($user, $form->get('password')->getData())
                );
            }
    
            // Persist and flush the changes
            $entityManager->persist($user);
            $entityManager->flush();
    
            // Redirect or do any other actions upon successful update
            return $this->redirectToRoute('updateuser');

        }
        
        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'formSubmitted' => $form->isSubmitted(),
        ]);
    }

}
    