<?php
declare(strict_types=1);

namespace App\Controller;


use App\Entity\Book;
use App\Form\AdminBookType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    #[Route('admin/book/index', name: 'app_admin_book_index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    //Ajouter une méthode create avec 2 paramètres.
    #[Route('admin/book/newBook', name : 'app_admin_book_newBook')]
    public function newBook(Request $request, BookRepository $repository): Response
    {
        $form = $this->createForm(AdminBookType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $bookValidated = $form->getData();
            $repository->add($bookValidated, true);

            return $this->redirectToRoute('app_admin_book_list');
        }

        $view = $form->createView();
        return $this->render('admin/book/newBook.html.twig', ['view'=>$view]);
    }

    #[Route('admin/book/list', name : 'app_admin_book_list')]
    public function list(BookRepository $repository): Response
    {
        $books = $repository->findAll();

        return $this->render('admin/book/list.html.twig', ['books' => $books]);
    }

     #[Route('/admin/book/update/{id}', name : 'app_admin_book_update')]
  public function update(Request $request, BookRepository $repository, Book $book) : Response {

    $form = $this->createForm(BookType::class, $book);
    $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()){
        $book= $form->getData();

        $repository->add($book, true);

        return $this->redirectToRoute('app_admin_book_list');
      }
      
      $view = $form->createView();

    return $this->render('admin/book/update.html.twig', ['book'=>$book, 'view'=>$view]);
  }

  // ______________________________________________________________

  #[Route('/admin/book/delete/{id}', name : 'app_admin_book_delete')]
  public function delete(BookRepository $repository, int $id) : Response {

    $book = $repository->find($id);

    $repository->remove($book, true);

    return $this->redirectToRoute('app_admin_book_list');
  }  
}
