<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="index_category")
     */

    public function index(Request $request):Response{

        $category = new Category();
        $form = $this->createForm(
            CategoryType::class, $category);

        $cat =$request->get($form->getName());

        if(isset($cat['name'])){
            $category->setName($cat['name']);
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
        }


        return $this->render('category/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }


}