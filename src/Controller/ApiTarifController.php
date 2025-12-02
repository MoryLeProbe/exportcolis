<?php

namespace App\Controller;

use App\Entity\Expedition;
use App\Service\TarifExpeditionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiTarifController extends AbstractController
{
    #[Route('/api/tarif', name: 'api_calcul_tarif', methods: ['POST'])]
    public function calculTarif(
        Request $request,
        EntityManagerInterface $em,
        TarifExpeditionService $tarifService
    ): JsonResponse {
        
        $expeditionId = $request->request->get('expeditionId');
        $poids = (float) $request->request->get('poids');

        if (!$expeditionId || $poids <= 0) {
            return new JsonResponse(['error' => 'Paramètres manquants'], 400);
        }

        $expedition = $em->getRepository(Expedition::class)->find($expeditionId);

        if (!$expedition) {
            return new JsonResponse(['error' => 'Expédition introuvable'], 404);
        }

        // Récupération des infos de l’expédition
        $type = $expedition->getType();
        $depart = $expedition->getPortDepart();
        $arrivee = $expedition->getPortArrivee();

        try {
            // Calcul du tarif complet (avec destination)
            $prix = $tarifService->calculerPrix($poids, $type, $depart, $arrivee);

            return new JsonResponse([
                'success' => true,
                'prix' => $prix
            ]);
            
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
