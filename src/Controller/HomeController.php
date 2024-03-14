<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Entity\PropertySearch;
use App\Services\MailerService;
use App\Form\PropertySearchType;
use App\Repository\RendezVousRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/rendez-vous', name: 'app_rendezvous')]
    public function index(): Response
    {
        return $this->render('home/rendezvous.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/mes_rendez-vous', name: 'app_mesrendezvous')]
    public function mesrendezvous(RendezVousRepository $rendezVousRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        $users = $this->getUser();
        $userRdv = $rendezVousRepository->findUserRdv($users, $search);
        $rdv = $paginator->paginate(
            $userRdv,
            $request->query->getInt('page', '1'),
            5
        );
        return $this->render('home/mesrendezvous.html.twig', [
            'reservations' => $rdv,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        return $this->render('home/profil.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/home', name: 'app_homeac')]
    public function homeac(): Response
    {
        return $this->render('home/homeac.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/profil_patient/editer_mot_de_passe/modal', name: 'app_modal')]
    public function modal(): Response
    {
        return $this->render('home/modal.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/rendez-vous/recapitulatif', name: 'app_recapitulatif', methods: ['POST'])]

    public function recapitulatif(ManagerRegistry $doctrine, MailerService $mailer, Request $request): Response
    {
        $user = $this->getUser();
        $entityManager = $doctrine->getManager();
        $reservation = new RendezVous();
        $reservation->setNomPatient($request->get('nom_patient'));
        $reservation->setPrenomPatient($request->get('prenom_patient'));
        $reservation->setAdresse($request->get('adresse'));
        $reservation->setEmailPatient($request->get('email_patient'));
        $reservation->setNumTel($request->get('num_tel'));
        $reservation->setService($request->get('service'));
        $reservation->setStatus('A Venir');
        $reservation->setAge($request->get('age'));
        $reservation->setSexe($request->get('sexe'));
        $reservation->setMotif($request->get('motif'));
        $reservation->setDateRdv($request->get('date_rdv'));
        $reservation->setHeureRes($request->get('heure_res'));

        $initialep = $user->getPrenom();
        $initialep = substr($initialep, 0, 1);

        $initialen = $user->getNom();
        $initialen = substr($initialen, 0, 1);

        $nbr_rand = '';
        for ($i = 0; $i < 10; $i++)
            $nbr_rand .= rand(0, 9);
        $numreference = 'RV00 ' . $nbr_rand;
        $reservation->setNumRef($numreference);

        $today = date("l d F Y");
        $reservation->setDateActuelle($today);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($reservation);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $message = "votre reservation a ete prise en compte";
        $mailMessage = $reservation->getNomPatient() . ' ' . $reservation->getPrenomPatient() . ' ' . $message;
        $mailer->sendEmail(content: $mailMessage);

        // return $this->redirectToRoute('app_rendezVous');
        return $this->render('home/recapitulatif.html.twig', [
            'persons' => $reservation,
            'personsp' => $initialep,
            'personsn' => $initialen,
            'numreference' => $numreference,
            'today' => $today,
        ]);
    }
}
