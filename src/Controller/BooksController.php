<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/books")
 */
class BooksController extends AbstractController
{
    /**
     * @Route("/add")
     */
    public function add()
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        return $this->render('books/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
