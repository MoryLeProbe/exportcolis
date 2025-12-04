<?php
namespace App\Service;

use App\Repository\TarifPortRepository;
use App\Repository\PortRepository;

class TarifExpeditionService
{
    public function __construct(private TarifPortRepository $tarifPortRepo, private PortRepository $portRepo) {}

    public function calculerPrix(float $poids, string $type, string $portDepartNom, string $portArriveeNom): float
    {
        // Récupération des objets Port par nom
        $portDepart = $this->portRepo->findOneBy(['nom' => $portDepartNom]);
        $portArrivee = $this->portRepo->findOneBy(['nom' => $portArriveeNom]);

        if (!$portDepart || !$portArrivee) {
            throw new \Exception("Port de départ ou d'arrivée introuvable.");
        }

        // Récupération du tarif selon ports & type
        $tarif = $this->tarifPortRepo->findOneBy([
            'portDepart' => $portDepart,
            'portArrivee' => $portArrivee,
            'typeTransport' => $type
        ]);

        if (!$tarif) {
            return 0; // Aucun tarif défini, prix = 0
        }

        // Calcul du prix = poids * tarif au kilo
        return $poids * $tarif->getPrixKg();
    }
}
