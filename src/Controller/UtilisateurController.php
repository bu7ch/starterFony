<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/utilisateurs')]
class UtilisateurController extends AbstractController
{
  #[Route("/", name: "utilisateur_index")]
  public function index(UtilisateurRepository $utilisateurRepository): Response
  {
    $utilisateurs = $utilisateurRepository->findAll();

    return $this->render('utilisateur/index.html.twig', [
      'utilisateurs' => $utilisateurs,
    ]);
  }

  #[Route("/new", name: "user_new")]
  public function new(Request $request, EntityManagerInterface $em): Response
  {
    $utilisateur = new Utilisateur();
    $form = $this->createForm(UtilisateurType::class, $utilisateur);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($utilisateur);
      $em->flush();

      return $this->redirectToRoute('utilisateur_index');
    }

    return $this->render('utilisateur/new.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  #[Route("/{id}", name: "user_show")]
  public function show(Utilisateur $user): Response
  {
    return $this->render('utilisateur/show.html.twig', [
      'user' => $user,
    ]);
  }

  #[Route("/{id}/edit", name: "user_edit")]
  public function edit(Request $request, Utilisateur $user, EntityManagerInterface $em): Response
  {
    $form = $this->createForm(UtilisateurType::class, $user);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->flush();

      return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
    }

    return $this->render('utilisateur/edit.html.twig', [
      'form' => $form->createView(),
      'user' => $user,
    ]);
  }

  #[Route("/user/{id}/delete", name: "user_delete")]
  public function delete(Request $request, Utilisateur $user, EntityManagerInterface $em): Response
   {
    if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
      $em->remove($user);
      $em->flush();
    }

    return $this->redirectToRoute('utilisateur_index');
   }
}
