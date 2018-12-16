<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/books")
 */
class BooksController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function list() {
        $books = $this->getDoctrine()->getRepository(Book::class)->findAll();

        return $this->render('books/list.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route("/add")
     */
    public function add(Request $request)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('books/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
