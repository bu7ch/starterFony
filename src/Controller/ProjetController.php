<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/projets')]
class ProjetController extends AbstractController
{
  #[Route('/', name: 'projet_index')]
  public function index(ProjetRepository $projetRepository, EntityManagerInterface $em): Response
  {
    $em->clear();
    return $this->render('projet/index.html.twig', [
      'projets' => $projetRepository->findAll(),
    ]);
  }
  #[Route('/new', name: 'projet_new', methods: ['GET', 'POST'])]
  public function new(Request $request, EntityManagerInterface $em): Response
  {
    $projet = new Projet();
    $form = $this->createForm(ProjetType::class, $projet);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($projet);
      $em->flush();

      return $this->redirectToRoute('projet_index');
    }

    return $this->render('projet/new.html.twig', [
      'projet' => $projet,
      'form' => $form->createView(),
    ]);
  }
  #[Route('/{id}', name: 'projet_show', methods: ['GET'])]
  public function show(Projet $projet): Response
  {
    return $this->render('projet/show.html.twig', [
      'projet' => $projet,
    ]);
  }
  #[Route('/{id}/edit', name: 'projet_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, Projet $projet, EntityManagerInterface $em): Response
  {
    $form = $this->createForm(ProjetType::class, $projet);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->flush();

      $this->addFlash('success', 'Projet mis à jour avec succès.');

      return $this->redirectToRoute('projet_index');
    }

    return $this->render('projet/edit.html.twig', [
      'projet' => $projet,
      'form' => $form->createView(),
    ]);
  }
}
