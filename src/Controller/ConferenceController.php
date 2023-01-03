<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ConferenceController extends AbstractController
{
    #[Route('/{controllerName}', name: 'home_page')]
    public function index(Environment $twig, ConferenceRepository $conferenceRepository, string $controllerName): Response
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
            'controller_name' => $controllerName,
        ]));
    }

    #[Route('/conference/{id}', name: 'conference')]
    public function show(Request $request, Environment $twig, Conference $conference, CommentRepository $commentRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($conference, $offset);

        return new Response($twig->render('conference/show.html.twig', [
            'conference' => $conference,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE)
            //'comments' => $commentRepository->findBy(['conference' => $conference], ['createdAt' => 'DESC']),
        ]));
    }
}
