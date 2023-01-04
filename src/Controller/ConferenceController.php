<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Conference;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ConferenceController extends AbstractController
{
    public function __construct (
        private EntityManagerInterface $entityManager,
    ){
    }

    #[Route('/', name: 'home_page')]
    public function index(ConferenceRepository $conferenceRepository, string $controllerName = 'toto'): Response
    {
        /* return new Response(<<<EOF
            <html>
                <body>
                <img src="/images/under-construction.gif" />
                </body>
            </html>
            EOF
        ); */
        return $this->render('conference/index.html.twig', [
            'conferences' => $conferenceRepository->findAll(),
            'controller_name' => $controllerName,
        ]);
    }

    #[Route('/conference/{slug}', name: 'conference')]
    public function show(Request $request, Conference $conference, CommentRepository $commentRepository, ConferenceRepository $conferenceRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($conference, $offset);

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);

        return $this->render('conference/show.html.twig', [
            'conferences' => $conferenceRepository->findAll(),
            'conference' => $conference,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
            'comment_form' => $form,
            //'comments' => $commentRepository->findBy(['conference' => $conference], ['createdAt' => 'DESC']),
        ]);
    }
}
