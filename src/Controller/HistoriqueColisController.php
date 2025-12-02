<?php

namespace App\Controller;

use App\Entity\Colis;
use App\Entity\HistoriqueColis;
use App\Form\HistoriqueColisType;
use App\Repository\HistoriqueColisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/historique/colis')]
final class HistoriqueColisController extends AbstractController
{
    #[Route(name: 'app_historique_colis_index', methods: ['GET'])]
    public function index(HistoriqueColisRepository $historiqueColisRepository): Response
    {
        return $this->render('historique_colis/index.html.twig', [
            'historique_colis' => $historiqueColisRepository->findAllOrderedByDateActionDesc(),
        ]);
    }

    #[Route('/new', name: 'app_historique_colis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $historiqueColi = new HistoriqueColis();
        $form = $this->createForm(HistoriqueColisType::class, $historiqueColi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coli = $historiqueColi->getColis();
            if ($coli) {
                $ancienStatut = $coli->getStatut();
                $nouveauStatut = $historiqueColi->getStatut();
                $historiqueColi->setDescription(sprintf(
                    'Le statut du colis est passé de "%s" à "%s".',
                    $ancienStatut,
                    $nouveauStatut
                ));
            }
            $entityManager->persist($historiqueColi);
            $entityManager->flush();

            return $this->redirectToRoute('app_historique_colis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('historique_colis/new.html.twig', [
            'historique_coli' => $historiqueColi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_historique_colis_show', methods: ['GET'])]
    public function show(HistoriqueColis $historiqueColi): Response
    {
        return $this->render('historique_colis/show.html.twig', [
            'historique_coli' => $historiqueColi,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_historique_colis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HistoriqueColis $historiqueColi, EntityManagerInterface $entityManager): Response
    {
        $ancienStatut = $historiqueColi->getStatut();
        $form = $this->createForm(HistoriqueColisType::class, $historiqueColi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coli = $historiqueColi->getColis();
            if ($coli) {
                $nouveauStatut = $historiqueColi->getStatut();
                $historiqueColi->setDescription(sprintf(
                    'Le statut du colis est passé de "%s" à "%s".',
                    $ancienStatut,
                    $nouveauStatut
                ));
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_historique_colis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('historique_colis/edit.html.twig', [
            'historique_coli' => $historiqueColi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_historique_colis_delete', methods: ['POST'])]
    public function delete(Request $request, HistoriqueColis $historiqueColi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$historiqueColi->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($historiqueColi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_historique_colis_index', [], Response::HTTP_SEE_OTHER);
    }
}
