<?php
// src/Controller/WildController.php


namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Season;
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
     * @return Response
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
            'programs' => $programs,
        ]);
    }

    /**
     ** Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug}", defaults={"slug" = null}, name="show")
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

    /**
     ** Getting a program with all the season
     *
     * @param string $slug The slugger
     * @Route("/showSeason/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="showByProgram")
     * @return Response
     */


    public function showByProgram(string $slug = ""): Response
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

        $programId = $program->getId();

        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(
                array('program' => $programId ) // Critere
            );

        // return
        return $this->render('wild/showSeason.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
            'slug'  => $slug,
        ]);
    }

    /**
     ** Getting all the episode of a season
     *
     * @param int $seasonId season
     * @Route("/episodes/{seasonId<^[0-9-]+$>}", defaults={"seasonId" = null}, name="showEpisode")
     * @return Response
     */


    public function showBySeason(int $seasonId): Response
    {
        if (!$seasonId) {
            throw $this
                ->createNotFoundException('No season with this Id');
        }

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $seasonId]);

        $program = $season->getProgram();
        $episodes = $season->getEpisodes();

        // si on ne trouve pas la season
        if (!$episodes) {
            throw $this->createNotFoundException(
                'No season found in season\'s table.'
            );
        }

        return $this->render('wild/showEpisode.html.twig', [
            'seasonId' => $seasonId,
            'season'=> $season,
            'episodes' => $episodes,
            'program' => $program

        ]);
    }

    /**
     ** Getting an episode with this id
     *
     * @param int $id episode
     * @Route("/episode/{slug}", defaults={"id" = null}, name="showOneEpisode")
     * @return Response
     */


    public function  showEpisode(Episode $episode){

        $season = $episode->getSeason();
        $program = $season->getProgram();

        return $this->render('wild/showOneEpisode.html.twig', [
            'season'=> $season,
            'episode' => $episode,
            'program' => $program

        ]);

    }
}
