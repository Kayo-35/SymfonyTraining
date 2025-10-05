<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Genre;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;

#[Route('/book', name: 'book.')]
final class BookController extends AbstractController
{
    private BookRepository $booksRepo;
    private EntityManagerInterface $dbManager;

    public function __construct(BookRepository $booksRepo, EntityManagerInterface $dbManager)
    {
        $this->booksRepo = $booksRepo;
        $this->dbManager = $dbManager;
    }
    //Index
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $books = $this->booksRepo->get();
        return $this->render('book/index.html.twig', [
            "books" => $books
        ]);
    }

    //Show
    #[Route('/{id}', name: 'show', requirements: ["id" => Requirement::POSITIVE_INT], methods: ['GET'])]
    public function show(int $id): Response
    {
        $book = $this->booksRepo->getOne($id);
        return $this->render('book/show.html.twig', [
            "book" => $book
        ]);
    }

    //Create
    #[Route('/new', name: 'create', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dbManager->persist($book);
            $this->dbManager->flush();
            $this->addFlash('created', 'A Bran New Book was created!');
            return $this->redirectToRoute('book.index');
        }

        return $this->render('book/create.html.twig', [
            "form" =>  $form,
            "book" => $book
        ]);
    }

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
