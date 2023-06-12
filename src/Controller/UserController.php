<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/users', name: 'app_user_list')]
    public function userList(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $user = new User();
        $registration_form = $this->createForm(UserType::class, $user);
        $registration_form->handleRequest($request);
        if ($registration_form->isSubmitted() && $registration_form->isValid()) {
            $user->setRoles(["ROLE_USER"]);
            $plaintextPassword = $registration_form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('app_user_list');
        }

        $users = $this->em->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            'registration_form' => $registration_form->createView(),
            'users' => $users
        ]);
    }

    #[Route('/user/delete/{id}', name: 'app_user_delete', requirements: ['id' => '\d+'])]
    public function userDelete(User $user): Response
    {
        $this->em->remove($user);
        $this->em->flush();
        return $this->redirectToRoute('app_user_list');
    }


    #[Route('/user/registration', name: 'app_user_registration')]
    public function userRegistration(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {

        $user = new User();
        $registration_form = $this->createForm(UserType::class, $user);
        $registration_form->handleRequest($request);
        if ($registration_form->isSubmitted() && $registration_form->isValid()) {
            $user->setRoles(["ROLE_USER"]);
            $plaintextPassword = $registration_form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('app_quote');
        }

        return $this->render('user/registration.html.twig', [
            'registration_form' => $registration_form->createView(),
        ]);
    }

    #[Route('/user/edit/{id}', name: 'app_user_edit', requirements: ['id' => '\d+'])]
    public function quoteEdit(User $user, Request $request,UserPasswordHasherInterface $passwordHasher): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        
        $registration_form = $this->createForm(UserType::class, $user);
        $registration_form->handleRequest($request);
        if ($registration_form->isSubmitted() && $registration_form->isValid()) {
            $user->setRoles(["ROLE_USER"]);
            $plaintextPassword = $registration_form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('app_user_list');
        }

        return $this->render('user/edit.html.twig', [
            'registration_form' => $registration_form->createView(),
        ]);
    }
}
