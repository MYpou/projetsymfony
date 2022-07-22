<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Form\AdminCategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/admin/index', name: 'app_admin_category_index')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig');
    }

    #[Route('admin/category/newCategogy', name : 'app_admin_category_newCategory')]
    public function newCategory(Request $request, CategoryRepository $repository): Response
    {
        $form = $this->createForm(AdminCategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $caregoryValidated = $form->getData();
            $repository->add($caregoryValidated, true);

            return $this->redirectToRoute('app_admin_category_list');
        }

        $view = $form->createView();

        return $this->render('admin/category/newCategory.html.twig', ['view'=>$view]);

    }

    #[Route('admin/category/list', name : 'app_admin_category_list')]
    public function list(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();

        return $this->render('admin/category/list.html.twig', ['categories'=>$categories]);
    }

    #[Route('/admin/category/update', name : 'app_admin_category_update')]
    public function update(Request $request, CategoryRepository $repository, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $category = $form->getData();
            $repository->add($category, true);

            return $this->redirectToRoute('app_admin_category_list');
        }

        $view = $form->createView();

        return $this->render('admin/category/update.html.twig', ['category'=>$category, 'view'=>$view]);
    }

    #[Route('admin/category/delete', name : 'app_admin_category_delete')]
    public function delete(CategoryRepository $repository, int $id): Response
    {
        $category = $repository->find($id);
        $repository->remove($category, true);

        return $this->redirectToRoute('app_admin_category_list');
    }
}
