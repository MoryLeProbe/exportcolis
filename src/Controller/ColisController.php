<?php

namespace App\Controller;

use App\Entity\Colis;
use App\Entity\HistoriqueColis;
use App\Form\ColisType;
use App\Repository\ColisRepository;
use App\Service\TarifExpeditionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/colis')]
final class ColisController extends AbstractController
{
    #[Route(name: 'app_colis_index', methods: ['GET'])]
    public function index(ColisRepository $colisRepository): Response
    {
        return $this->render('colis/index.html.twig', [
            'colis' => $colisRepository->findAllOrderedByCreatedAtDesc(),
        ]);
    }

    #[Route('/new', name: 'app_colis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, TarifExpeditionService $tarifService): Response
    {
        $coli = new Colis();
        $form = $this->createForm(ColisType::class, $coli);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $expedition = $coli->getExpedition();
            $type = $expedition->getType();
            $poids = $coli->getPoids();
            $depart = $expedition->getPortDepart();
            $arrivee = $expedition->getPortArrivee();

            // Calcul automatique du prix
            $prix = $tarifService->calculerPrix($poids, $type, $depart, $arrivee);
            $coli->setPrix($prix);

            $entityManager->persist($coli);
            $entityManager->flush();

            return $this->redirectToRoute('app_colis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('colis/new.html.twig', [
            'coli' => $coli,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_colis_show', methods: ['GET'])]
    public function show(Colis $coli): Response
    {
        return $this->render('colis/show.html.twig', [
            'coli' => $coli,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_colis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Colis $coli, EntityManagerInterface $entityManager): Response
    {
        // 1️⃣ On garde l'ancien statut pour vérifier s’il change
        $ancienStatut = $coli->getStatut();

        $form = $this->createForm(ColisType::class, $coli);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );

                $coli->setPhoto($newFilename);
            }

                // 2️⃣ Si le statut a changé → on enregistre l’historique
                if ($coli->getStatut() !== $ancienStatut) {

                    $historique = new HistoriqueColis();
                    $historique->setColis($coli);
                    $historique->setStatut($coli->getStatut());
                    $historique->setDescription(sprintf(
                        'Le statut du colis est passé de "%s" à "%s".',
                        $ancienStatut,
                        $coli->getStatut()
                    ));
                    $historique->setDateAction(new \DateTime());

                    $entityManager->persist($historique);
                }

            $entityManager->flush();

            return $this->redirectToRoute('app_colis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('colis/edit.html.twig', [
            'coli' => $coli,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_colis_delete', methods: ['POST'])]
    public function delete(Request $request, Colis $coli, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coli->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($coli);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_colis_index', [], Response::HTTP_SEE_OTHER);
    }
}
