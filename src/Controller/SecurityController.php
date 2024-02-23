<?php

namespace App\Controller;
use App\Entity\User1;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface; // Import PasswordEncoderInterface

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    #[Route(path: '/loginadmin', name: 'admin_login')]
    public function loginadmin(AuthenticationUtils $authenticationUtils): Response
    {
        

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/admin_login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

    }


    
    
    #[Route('/forgot-password', name: 'forgot_password')]
    public function forgotPasswordPage(): Response
    {
        return $this->render('security/forgot_password.html.twig');
    }

    #[Route('/reset-password', name: 'reset_password')]
    public function resetPasswordPage(): Response
    {
        return $this->render('security/reset_password.html.twig');
    }
}

