<?php
// src/Controller/WildController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{
    public function index() :Response
    {
        /**
         * @Route("/wild", name="wild_index")
         */
        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }

    /**
     * @Route("/show/{slug}" ,requirements={"slug"="[a-z0-9-]+$"}, defaults={"slug" = "Aucune série sélectionnée, veuillez choisir une série"})
     */
   public function show(string $slug):Response
    {
        $newSlug= ucfirst($slug);
        $replaceSlug= str_replace('-',' ',$newSlug);
        return $this->render('wild/show.html.twig', ['slug' => $replaceSlug]);
    }


}