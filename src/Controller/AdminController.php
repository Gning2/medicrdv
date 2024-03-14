<?php

namespace App\Controller;

use doctrine;
use App\Entity\RendezVous;
use App\Entity\PlageHoraire;
use App\Form\RendezVousType;
use App\Form\HoraireEditType;
use App\Form\PlageHoraireType;
use App\Services\MailerService;
use App\Repository\UserRepository;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PlageHoraireRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminController extends AbstractController
{
    #[Route('/medecin/Neurologie', name: 'app_neurologie')]
    public function index(UserRepository $userRepository,PaginatorInterface $paginator, RendezVousRepository $rendezVousRepository, Request $request ): Response
    {
        $users = $this->getUser();
        $rendezvous = $rendezVousRepository->findServiceRDV($users);
        $rdv = $paginator->paginate(
            $rendezvous,
            $request->query->getInt('page', '1'),
            10
        );
        $rendezVous = $rendezVousRepository->findRdv($users);
        $rdvCountByStatus = $rendezVousRepository->countRdvByStatus($users);
        $rdvcountRdvByDate = $rendezVousRepository->countRdvByDate($users);
        
        return $this->render('admin/index.html.twig',[
            'reservations' => $rdv,
            'RdvCompteurs'=>$rendezVous,
            'CompteurByStatus'=>$rdvCountByStatus,
            'CompteurByDate'=>$rdvcountRdvByDate,  
        ]);
    }
    #[Route('/medecin/{id}', name: 'app_admin_med2')]
    public function getOne(int $id, RendezVousRepository $rendezvousRep,ManagerRegistry $doctrine): Response
    {
        $rendezvous = $rendezvousRep->find(['id'=>$id]);

        return  new JsonResponse([
            'numRef' => $rendezvous->getNumRef(),
            'nom' => $rendezvous->getNomPatient(),
            'prenom' => $rendezvous->getPrenomPatient(),
            'email' => $rendezvous->getEmailPatient(),
            'numTel' => $rendezvous->getNumTel(),
            'adresse' => $rendezvous->getAdresse(),
            'age' => $rendezvous->getAge(),
            'service' => $rendezvous->getService(),
            'dateRdv' => $rendezvous->getDateRdv(),
            'heureRes' => $rendezvous->getHeureRes(),
            'status' => $rendezvous->getStatus(),
        ]);
        
    }

    #[Route('/medecin_horaire', name: 'app_horaire')]
    public function horaire(PlageHoraireRepository $plageHoraireRepository): Response
    {
        $horairesUser=$plageHoraireRepository->findBy(['user'=> $this->getUser()]);
        return $this->render('admin/horaire.html.twig',[
            'userHoraires' => $horairesUser,
        ]);
    }

    #[Route('/medecin_horaire/edit/{id}', name: 'app_horaireedit', methods: ['GET','POST'])]
    public function horaireedit(EntityManagerInterface $manager,PlageHoraire $plageHoraire, Request $request): Response
    {
        $form = $this->createForm(HoraireEditType::class, $plageHoraire);
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() )
        {
            
            $form->getData();
            $manager->flush();
    
            $this->addFlash(
                'notice',
                'Horaire modifié avec succès.'
            );
            return $this->redirectToRoute('app_horaire'); 
        }

        return $this->render('admin/horaireedit.html.twig',[
            'form' => $form->createView(),
        ]); 
    }

    #[Route('/medecin/Neurologie/encours/{id}', name: 'app_medecinencours')]
    
        public function encours(ManagerRegistry $doctrine, int $id): Response
        {
            $entityManager = $doctrine->getManager();
            $Encours = $entityManager->getRepository(RendezVous::class)->find($id);
    
            if (!$Encours) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
    
            $Encours->setStatus('En Cours');
            $entityManager->persist($Encours);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_neurologie');
        }

        #[Route('/medecin/neurologie/terminer/{id}', name: 'app_adminterminer')]
    
        public function terminer(ManagerRegistry $doctrine, int $id): Response
        {
            $entityManager = $doctrine->getManager();
            $Terminer = $entityManager->getRepository(RendezVous::class)->find($id);
    
            if (!$Terminer) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
    
            $Terminer->setStatus('Terminer');
            
            $entityManager->persist($Terminer);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_neurologie');
        }

        #[Route('/creation_rendez-vous', name: 'rendez-vous_app', methods: ['GET','POST'])]
    public function newRDv(EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(RendezVousType::class);
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() )
        {
            $nbr_rand = '';
            for ($i = 0; $i < 10; $i++)
                $nbr_rand .= rand(0, 9);
            $numreference = 'RV00 ' . $nbr_rand;
            $rdv = $form->getData()
                        ->setStatus('A Venir')
                        ->setNumRef($numreference);
            $manager->persist($rdv);
            $manager->flush();
    
            $this->addFlash(
                'notice',
                'Rendez-vous enregistrer avec succès.'
            );
            return $this->redirectToRoute('rendez-vous_app'); 
        }

        return $this->render('admin/newRdv.html.twig',[
            'form' => $form->createView(),
        ]); 
    }

    #[Route('/medecin_horaire/nouveau', name: 'app_horaire_new')]
    public function newhoraire(EntityManagerInterface $manager, Request $request): Response
    {
        $plageHoraire = new PlageHoraire();
        $form = $this->createForm(PlageHoraireType::class,$plageHoraire);
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() )
        {
                
            $horaire = $form->getData()
                            ->setUser($this->getUser());
            $manager->persist($horaire);
            $manager->flush();
    
            $this->addFlash(
                'notice',
                'Horaire enregistré avec succès.'
            );
            return $this->redirectToRoute('app_horaire_new'); 
        }

        return $this->render('admin/newPlageHoraire.html.twig',[
            'form' => $form->createView(),
        ]);
        
    }
}
