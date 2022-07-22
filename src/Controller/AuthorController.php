<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Author;
use App\Form\AdminAuthorType;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{
    #[Route('/admin/index', name: 'app_admin_author_index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('admin/author/create', name : 'app_admin_author_create')]
  public function create(Request $request, AuthorRepository $repository): Response 
  { 

      //Avec formulaire créé avec Symfony
      $form = $this->createForm(AdminAuthorType::class);      
      $form->handleRequest($request);
      
      if ($form->isSubmitted() && $form->isValid()){
        $authorValidated = $form->getData();        
        $repository->add($authorValidated, true);
        
        return $this->redirectToRoute('app_admin_author_list');
    }
    
    $view = $form->createView();
    
    return $this->render('admin/author/create.html.twig', ['view'=>$view]);

    // Sans formulaire créé avec Symfony
    // if($request->isMethod('POST')){
    
    //   $name = $request->request->get('name');
    //   $description = $request->request->get('description');
    //   $imageUrl = $request->request->get('imageUrl');
    
    //   $author = new Author();
    
    //   $author->setName($name);
    //   $author->setDescription($description);
    //   $author->setImageUrl($imageUrl);
    
    //   $repository->add($author, true);
    
    //   return $this->redirectToRoute('app_author_list');
    // }
    }
    
    #[Route('admin/author/list', name : 'app_admin_author_list')]
    public function list(AuthorRepository $repository) : Response {
  
      $authors = $repository->findAll();
  
      return $this->render('admin/author/list.html.twig', ['authors'=>$authors]);
    }
    #[Route('/admin/author/update/{id}', name : 'app_admin_author_update')]
  public function update(Request $request, AuthorRepository $repository, Author $author) : Response {

    //$author = $repository->find($id);
    
    // if($request->isMethod('POST')){

    //   $name = $request->request->get('name');
    //   $description = $request->request->get('description');
    //   $imageUrl = $request->request->get('imageUrl');

    //   $author->setName($name);
    //   $author->setDescription($description);
    //   $author->setImageUrl($imageUrl);

    //   $repository->add($author, true);

    //   return $this->redirectToRoute('app_author_list');
    // }

    $form = $this->createForm(AdminAuthorType::class, $author);

    $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()){
        $author= $form->getData();

        $repository->add($author, true);

        return $this->redirectToRoute('app_admin_author_list');
      }
      
      $view = $form->createView();

      return $this->render('admin/author/update.html.twig', ['author'=>$author, 'view'=>$view]);

  }

  // ______________________________________________________________

  #[Route('admin/author/delete/{id}', name : 'app_admin_author_delete')]
  public function delete(AuthorRepository $repository, int $id) : Response {

    $author = $repository->find($id);

    $repository->remove($author, true);

    return $this->redirectToRoute('app_admin_author_list');
  }
}
