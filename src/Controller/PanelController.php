<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Repository\NotesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanelController extends AbstractController
{
    private $data;
    private $result;
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/panel', name: 'app_panel')]
    public function index(NotesRepository $notesRepo,SessionInterface $session): Response
    {
        $data = $notesRepo->findBy(['creator' => $session->get('_security.last_username')]);

        return $this->render('panel/index.html.twig', [
            'controller_name' => 'PanelController',
            'data' => $data,
            'result' => 'nothing'
        ]);
    }

    #[Route('/addNote',name: 'app__add')]
    public function add(Request $request, SessionInterface $session, NotesRepository $notesRepo):Response
    {
        $this->data = [];
        $this->result = true;

        if(!$request -> request -> get('title') || !$request->request->get('content')) {
            $this->result = false;
        } 
        else {
            $note = new Notes();
            
            $note->setTitle($request->request->get('title'));
            $note->setContent($request->request->get('content'));
            $note->setCreator($session->get('_security.last_username'));

            $this->em->persist($note);
            $this->em->flush();
        }

        $data = $notesRepo->findBy(['creator' => $session->get('_security.last_username')]);

        return $this->render('panel/index.html.twig', [
            'controller_name' => 'PanelController',
            'data' => $data,
            'result' => $this -> result
        ]);
    }
}
