<?php
// src/Controller/WildController.php
use Symfony\Component\HttpFoundation\Response;

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/wild", name="wild_")
 */


class WildController extends AbstractController
{

    /**
     * show all rows for Program's entity
     *
     * @Route("", name="index")
     *  @return Response
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();


        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program table, Dude!'
            );
        }


        return $this->render('wild/index.html.twig', [
            'programs' => $programs
        ]);
    }

    /**
     ** Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
     * @return Response
     */
    public function show(string $slug = ""): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }

        $replaceSlug = str_replace('-', ' ', $slug);
        $newSlug = ucwords($replaceSlug);

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($newSlug)]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' . $slug . ' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
        ]);
    }

    /**
     ** Getting a list of 3 last series of a catagory
     *
     * @param string $categoryName The category name
     * *@Route("/category/{categoryName}", name="show_category")
     * @return Response
     */
    public function showByCategory(string $categoryName) {

        $categoryId = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        if (!$categoryId) {
            throw $this->createNotFoundException(
                'Ohhhh, pas de bol, Yen a plus!!!.'
            );
        }

        $categoryId =$categoryId->getId();

        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(
            array('category' => $categoryId ), // Critere
            array('id' => 'desc'),        // Tri
            3 ,                         // Limite
            0
        );

        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }

        return $this->render('wild/category.html.twig', [
            'programs' => $programs, 'category' => $categoryName
        ]);
    }
}

