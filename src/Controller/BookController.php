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
            return $this->redirectToRoute('book.index');
        }

        return $this->render('book/create.html.twig', [
            "form" =>  $form->createView(),
            "book" => $book,
            "method" => 'POST'
        ]);
    }

    //Edit
    #[Route('/{id}/edit', name: 'edit', requirements: ["id" => Requirement::POSITIVE_INT], methods: ['GET'])]
    public function edit(int $id): Response
    {
        $book = $this->dbManager->find(Book::class, $id);
        $form = $this->createForm(BookType::class, $book);
        return $this->render('book/edit.html.twig', [
            "form" => $form->createView(),
            "method" => 'PUT'
        ]);
    }
    //Update
    #[Route('/{id}/edit', name: 'put', requirements: ["id" => Requirement::POSITIVE_INT], methods: ['PUT'])]
    public function update(Book $book, Request $request): Response
    {
        $bookData = $request->request->all()['book'];
        $book->setName($bookData['name'])
            ->setAuthor($this->dbManager->find(Author::class, (int) $bookData['author']))
            ->setGenre($this->dbManager->find(Genre::class, (int) $bookData['genre']))
            ->setSinopse($bookData['sinopse']);

        $this->dbManager->persist($book);
        $this->dbManager->flush();

        return $this->redirectToRoute('book.show',[
            "id" => $book->getId()
        ]);
    }
    //Delete
    #[Route('/{id}', name: 'delete', requirements: ["id" => Requirement::POSITIVE_INT], methods: ['DELETE'])]
    public function destroy(int $id): Response
    {
        $book = $this->dbManager->find(Book::class, $id);
        $this->dbManager->remove($book);
        $this->dbManager->flush();

        return $this->redirectToRoute('book.index');
    }
}
