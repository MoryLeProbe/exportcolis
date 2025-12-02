<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\ColisRepository;
use App\Repository\ExpeditionRepository;
use App\Repository\HistoriqueColisRepository;
use App\Repository\PaiementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(
        ClientRepository $clientRepository,
        ColisRepository $colisRepository,
        ExpeditionRepository $expeditionRepository,
        PaiementRepository $paiementRepository,
        HistoriqueColisRepository $historiqueColisRepository
    ): Response {
        
        // Totaux
        $totalClients = $clientRepository->count([]);
        $totalColis = $colisRepository->count([]);
        $totalExpeditions = $expeditionRepository->count([]);
        $totalPaiements = $paiementRepository->count([]);

        // 5 derniers colis
        $derniersColis = $colisRepository->findBy([], ['createdAt' => 'DESC'], 5);

        // Récupérer les 10 derniers historiques
        $historiques = $historiqueColisRepository->findBy([], ['dateAction' => 'DESC'], 10);

        return $this->render('dashboard/index.html.twig', [
            'totalClients'     => $totalClients,
            'totalColis'       => $totalColis,
            'totalExpeditions' => $totalExpeditions,
            'totalPaiements'   => $totalPaiements,
            'derniersColis'    => $derniersColis,
            'historiques'      => $historiques,
        ]);
    }
}
