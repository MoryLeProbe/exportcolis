<?php
namespace App\Service;

class TarifExpeditionService
{
    private array $tarifs = [
        'AERIEN' => [
            'ABIDJAN' => [
                'PARIS' => 6000,
                'MADRID' => 5500,
                'BRUXELLES' => 6500,
            ],
        ],
        'MARITIME' => [
            'ABIDJAN' => [
                'PARIS' => 2500,
                'MARSEILLE' => 2000,
            ],
        ],
    ];

    public function calculerPrix(float $poids, string $type, string $depart, string $arrivee): float
    {
        if (!isset($this->tarifs[$type][$depart][$arrivee])) {
            throw new \Exception("Tarif non défini pour : $type - $depart → $arrivee");
        }

        $tarifKg = $this->tarifs[$type][$depart][$arrivee];

        return $poids * $tarifKg;
    }
}
