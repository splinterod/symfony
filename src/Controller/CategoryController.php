<?php

namespace App\Controller;

use App\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="index_category")
     * @IsGranted("ROLE_ADMIN")
     */


    public function index(Request $request):Response{

        $category = new Category();
        $form = $this->createForm(
            CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
        }

        return $this->render('category/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }


}