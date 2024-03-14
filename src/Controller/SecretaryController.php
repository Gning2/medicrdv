<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\RendezVousRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecretaryController extends AbstractController
{
    #[Route('/secretaire', name: 'app_secretary')]
    public function index(UserRepository $userRepository, Request $request, PaginatorInterface $paginator,RendezVousRepository $rendezVousRepository): Response
    {
        $allrdv = $rendezVousRepository->findAllRdvSecretary();
        $rdv = $paginator->paginate(
            $allrdv,
            $request->query->getInt('page', '1'),
            10
        );
        $rendezVous = $rendezVousRepository->findAllRdv();
        $countByDate = $rendezVousRepository->countAllRdvByDate();
        $countByStatus = $rendezVousRepository->countAllRdvByStatus();
        return $this->render('secretary/page.html.twig', [
            'rdvalls' => $rdv,
           'CompteurAllRdv' => $rendezVous,
           'CountAllRdvByDate' => $countByDate,
           'CountAllRdvByStatus' => $countByStatus,
        ]);
    }
}
