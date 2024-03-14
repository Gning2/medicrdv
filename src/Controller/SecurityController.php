<?php

namespace App\Controller;

use doctrine;
use App\Entity\User;
use App\Form\EditProfileType;
use App\Form\ResetPasswordRequestType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route(path:'/profil_patient', name:'app_patient_profil')]
    public function profilavt(): Response
    {
        return $this->render('security/userprofile.html.twig');
    }

    #[Route(path:'/profil_patient/editer', name:'app_profil_edit')]
    public function profil(EntityManagerInterface $manager, Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Votre profil a été mis à jour avec succès.'
            );
            return $this->redirectToRoute('app_patient_profil');
        }
        return $this->render('security/userprofiledit.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    #[Route(path:'/profil_patient/editer_mot_de_passe', name:'app_password_edit')]
    public function passwordEdit(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager): Response
    {
        if($request->isMethod('POST')){
            
            $user = $this->getUser();
            if($request->request->get('pass') == $request->request->get('pass2')){
                $hashedPassword = $passwordHasher->hashPassword($user, $request->request->get('pass'));
                $user->setPassword($hashedPassword);
                $manager->flush();
                $this->addFlash('notice', 'Votre mot de passe a été mis à jour avec succès.');
                return $this->redirectToRoute('app_patient_profil');

            }else{
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identitiques.');
            }
        }
        return $this->render('security/passwordedit.html.twig');
    }

    #[Route(path:'/profil_patient/verify_mot_de_passe', name:'app_password_verify')]
    public function passworReset(Request $request): Response
    {
        if($request->isMethod('POST')){
            $user = $this->getUser();
            $userPass = $user->getPassword();
            dump($userPass);
            if(password_verify($request->request->get('pass3'),$userPass)){
                return $this->redirectToRoute('app_password_edit');
            }else{
                $this->addFlash('error', 'Mot de passe incorrect.');
            }
        }
        return $this->render('security/actuelPassword.html.twig');
    }


    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path:'/reset_password', name:'forgotten_password')]
    public function forgottenPassword(Request $request): Response
    {
        $form = $this->createForm(ResetPasswordRequestType::class);
        $form->handleRequest($request);
        
        return $this->render('security/reset_password_request.html.twig',[
            'requestPassForm'=> $form->createView()
        ]);
    }

    #[Route(path:'/registerss', name:'app_registerss')]
    public function registerss(Request $request): Response
    {
        return $this->render('security/register.html.twig',[
        ]);
    }


    #[Route(path:'/registers', name:'app_registers')]
    public function registers(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $hashPassword): Response
    {
        $entityManager = $doctrine->getManager();
        $user = new User();
        $user->setNom($request->get('nom'));
        $user->setPrenom($request->get('prenom'));
        $user->setAdresse($request->get('adresse'));

        $user->setEmail($request->get('email'));
        
        $user->setTelephone($request->get('telephone'));

        $Passwordhash = $hashPassword->hashPassword($user ,$request->request->get('password'));
        $user->setPassword($Passwordhash);

        $user->setMoisnaissance($request->get('moisnaissance'));
        $user->setAnneenaissance($request->get('anneenaissance'));
        $user->setSexe($request->get('sexe'));

        $nbr_rand = '';
        for ($i = 0; $i < 10; $i++)
            $nbr_rand .= rand(0, 8);
        $numeropatient = 'NP ' . $nbr_rand;
        $user->setNumeroPatient($numeropatient);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->render('home/modal.html.twig',[

        ]);
    }
}
