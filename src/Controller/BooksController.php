<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookLocationType;
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

    /**
     * @Route("/borrow/{id}")
     */
    public function borrow($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);
        $book->setIsBorrowed(true);
        $book->setCurrentReader($this->getUser());
        $entityManager->flush();

        return $this->render('books/borrow_success.html.twig');
    }

    /**
     * @Route("/return/{id}")
     */
    public function return($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);
        $book->setIsBorrowed(false);
        $book->setCurrentReader(null);
        $entityManager->flush();

        return $this->render('books/return_success.html.twig');
    }

    /**
     * @Route("/update-location/{id}", name="app_books_update_location")
     */
    public function updateLocation(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);
        $form = $this->createForm(BookLocationType::class, $book, [
            'action' => $this->generateUrl('app_books_update_location', ['id' => $id])
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $referer = $request->headers->get('referer');

            if ($referer == NULL) {
                $url = $this->generateUrl('app_homepage');
            } else {
                $url = $referer;
            }

            return $this->redirect($url);
        }

        return $this->render('books/update_location.html.twig', [
            'form' => $form->createView(),
            'id' => $id
        ]);
    }
}
