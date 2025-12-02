<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\Expedition;
use App\Form\PaiementType;
use App\Repository\PaiementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/paiement')]
final class PaiementController extends AbstractController
{
    #[Route(name: 'app_paiement_index', methods: ['GET'])]
    public function index(PaiementRepository $paiementRepository): Response
    {
        return $this->render('paiement/index.html.twig', [
            'paiements' => $paiementRepository->findAllOrderedByCreatedAtDesc(),
        ]);
    }

    #[Route('/new/{expeditionId}', name: 'app_paiement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, int $expeditionId, EntityManagerInterface $entityManager): Response
    {
        $expedition = $entityManager->getRepository(Expedition::class)->find($expeditionId);
        if (!$expedition) {
            throw $this->createNotFoundException('Expédition non trouvée');
        }

        $paiement = new Paiement();
        $paiement->setExpedition($expedition);
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $montantTotalPaye = 0;
            foreach ($expedition->getPaiements() as $p) {
                $montantTotalPaye += $p->getMontant();
            }
            $resteAPayer = $expedition->getPrix() - $montantTotalPaye;

            if ($paiement->getMontant() > $resteAPayer) {
                $this->addFlash('error', 'Montant trop élevé !');
                return $this->redirectToRoute('app_expedition_show', ['id' => $expedition->getId()]);
            }

            $entityManager->persist($paiement);
            $entityManager->flush();

            return $this->redirectToRoute('app_expedition_show', ['id' => $expedition->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('paiement/new.html.twig', [
            'paiement' => $paiement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_paiement_show', methods: ['GET'])]
    public function show(Paiement $paiement): Response
    {
        return $this->render('paiement/show.html.twig', [
            'paiement' => $paiement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_paiement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Paiement $paiement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('paiement/edit.html.twig', [
            'paiement' => $paiement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_paiement_delete', methods: ['POST'])]
    public function delete(Request $request, Paiement $paiement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paiement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($paiement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/recu', name: 'app_paiement_recu')]
    public function recu(Paiement $paiement): Response
    {
        return $this->render('paiement/recu.html.twig', [
            'paiement' => $paiement
        ]);
    }

}
