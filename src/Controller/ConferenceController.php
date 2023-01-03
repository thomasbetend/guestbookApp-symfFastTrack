<?php

namespace App\Controller;

use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ConferenceController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function index(Environment $twig, ConferenceRepository $conferenceRepository): Response
    {
        /* return new Response(<<<EOF
            <html>
                <body>
                <img src="/images/under-construction.gif" />
                </body>
            </html>
            EOF
        ); */

        return new Response ($twig->render('conference/index.html.twig', [
            'conferences' => $conferenceRepository->findAll(),
        ]));
    }
    
}
