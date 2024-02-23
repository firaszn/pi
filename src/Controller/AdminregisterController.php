<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use App\Repository\User1Repository;

class AdminregisterController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dash')]
    public function registeradmin(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        return $this->render('user/dashboard.html.twig', [
        
        ]);
    }
   
    #[Route('/list', name: 'list_user')]
public function list(User1Repository $userRepository, Request $request): Response
{ 
    $users = $userRepository->findAll();

    return $this->render('user/list.html.twig', [
        'users' => $users
    ]);
}
#[Route('/detail/{id}', name: 'detail_user')]
    public function detail(int $id, User1Repository $userRepository): Response
    { 
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        return $this->render('user/detail.html.twig', [
            'user' => $user
        ]);
    }
#[Route('/user/delete/{id}', name: 'deleteuser')]
    public function deleteUser(int $id, EntityManagerInterface $entityManager, User1Repository $userRepository): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('list_user');

    }
}