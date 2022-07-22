<?php

namespace App\Controller;

use App\Entity\PublishingHouse;
use App\Form\AdminPublishingHouseType;
use App\Repository\PublishingHouseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublishingHouseController extends AbstractController
{
    #[Route('admin/index/', name: 'app_admin_publishing_house_index')]
    public function index(): Response
    {
        return $this->render('admin/publishing_house/index.html.twig');
    }

    //Ajouter une methode create
    #[Route('admin/publishing_house/create', name : 'app_admin_publishing_house_create')]
    public function create(Request $request, PublishingHouseRepository $repository): Response
    {
        $form = $this->createForm(AdminPublishingHouseType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $publishingHouseValidated = $form->getData();
            $repository->add($publishingHouseValidated, true);

            return $this->redirectToRoute('app_admin_publishing_house_list');
        }

        $view = $form->createView();
        return $this->render('admin/publishing_house/create.html.twig', ['view'=>$view]);
    }

    #[Route('admin/publishing_house/list', name : 'app_admin_publishing_house_list')]
    public function list(PublishingHouseRepository $repository): Response
    {
        $houses = $repository->findAll();

        return $this->render('admin/publishing_house/list.html.twig', ['houses' => $houses]);
    }

    #[Route('admin/publishing_house/update/', name : 'app_admin_publishing_house_update')]
    public function update(Request $request, PublishingHouseRepository $repository, PublishingHouse $house): Response
    {
        $form = $this->createForm(PublishingHouseType::class, $house);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $house = $form->getData();
            $repository->add($house, true);

            return $this->redirectToRoute('app_admin_publishing_house_list');
        }

        $view = $form->createView();

        return $this->render('admin/publishing_house/update.html.twig');
    }

    #[Route('admin/publishing_house/delete', name : 'app_admin_publishing_house_delete')]
    public function delete(PublishingHouseRepository $repository, int $id): Response
    {
        $house = $repository->find($id);
        $repository->remove($house, true);
        
        return $this->redirectToRoute('app_admin_publishing_house_list');
    }
}
