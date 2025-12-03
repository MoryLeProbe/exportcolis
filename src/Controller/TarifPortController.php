<?php

namespace App\Controller;

use App\Entity\TarifPort;
use App\Form\TarifPortType;
use App\Repository\TarifPortRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tarif/port')]
final class TarifPortController extends AbstractController
{
    #[Route(name: 'app_tarif_port_index', methods: ['GET'])]
    public function index(TarifPortRepository $tarifPortRepository): Response
    {
        return $this->render('tarif_port/index.html.twig', [
            'tarif_ports' => $tarifPortRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tarif_port_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tarifPort = new TarifPort();
        $form = $this->createForm(TarifPortType::class, $tarifPort);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tarifPort);
            $entityManager->flush();

            return $this->redirectToRoute('app_tarif_port_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tarif_port/new.html.twig', [
            'tarif_port' => $tarifPort,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tarif_port_show', methods: ['GET'])]
    public function show(TarifPort $tarifPort): Response
    {
        return $this->render('tarif_port/show.html.twig', [
            'tarif_port' => $tarifPort,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tarif_port_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TarifPort $tarifPort, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TarifPortType::class, $tarifPort);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tarif_port_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tarif_port/edit.html.twig', [
            'tarif_port' => $tarifPort,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tarif_port_delete', methods: ['POST'])]
    public function delete(Request $request, TarifPort $tarifPort, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tarifPort->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tarifPort);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tarif_port_index', [], Response::HTTP_SEE_OTHER);
    }
}
