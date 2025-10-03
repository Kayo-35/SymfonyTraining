<?php

namespace App\Controller;

use App\Entity\Genre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\BookRepository;

#[Route('/book', name: 'book.')]
final class BookController extends AbstractController
{
    private BookRepository $booksRepo;

    public function __construct(BookRepository $booksRepo)
    {
        $this->booksRepo = $booksRepo;
    }
    //Index
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $books = $this->booksRepo->get();
        return $this->render('book/index.html.twig',[
            "books" => $books
        ]);
    }

    //Show
    #[Route('/{id}', name: 'show', requirements: ["id" => Requirement::POSITIVE_INT], methods: ['GET'])]
    public function show(int $id): Response
    {
        $book = $this->booksRepo->getOne($id);
        return $this->render('book/show.html.twig',[
            "book" => $book
        ]);
    }

    //Create
    #[Route('/create', name: 'create', methods: ['GET'])]
    public function create(): Response {}
    //Store
    #[Route('/create', name: 'test', methods: ['POST'])]
    public function store(): Response {}
    //Edit
    #[Route('/{id}/edit', name: 'edit', requirements: ["id" => Requirement::POSITIVE_INT], methods: ['GET'])]
    public function edit()
    {
        return $this->render('book/edit.html.twig');
    }
    //Update
    #[Route('/{id}/edit', name: 'put', requirements: ["id" => Requirement::POSITIVE_INT], methods: ['PUT'])]
    public function update()
    {
        //Do the things
    }
    //Delete
    #[Route('/{id}', name: 'delete', requirements: ["id" => Requirement::POSITIVE_INT], methods: ['DELETE'])]
    public function destroy()
    {
        //Destroy the instance
    }
}
