<?php

namespace App\Controller;

use App\Entity\Contribution;
use App\Form\ContributionType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContributionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/contributions')]
class ContributionController extends AbstractController
{
  #[Route('/', name: 'contribution_index')]
  public function index(ContributionRepository $contributionRepository): Response
  {
    $contributions = $contributionRepository->findAll();
    return $this->render('contribution/index.html.twig', [
      'contributions' => $contributions,
    ]);
  }
  #[Route('/new', name: 'contribution_new')]
  public function new(Request $request, EntityManagerInterface $em): Response
  {
    $contribution = new Contribution();
    $form = $this->createForm(ContributionType::class, $contribution);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $projet = $contribution->getProjet();
      $em->persist($contribution);

      $projet->updateMontantActuel();
      $em->flush();

      $this->addFlash('success', 'Contribution ajoutée avec succès.');
      return $this->redirectToRoute('contribution_index');
    }
    return $this->render('contribution/new.html.twig', [
      'form' => $form->createView(),
    ]);
  }
}
