<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contributions')]
class ContributionController extends AbstractController
{
    #[Route('/', name: 'contribution_index')]
    public function index(): Response
    {
        return $this->render('contribution/index.html.twig', [
            'controller_name' => 'ContributionController',
        ]);
    }
}
