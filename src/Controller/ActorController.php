<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actor" , name="actor")
 */
class ActorController extends AbstractController
{
    /**
     * @Route("/{name}", name="_show", methods={"GET"})
     */
    public function show($name): Response
    {

        if (!$name) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }

        $name = ucwords(str_replace('-', ' ', $name));

        $actor = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findOneBy(['name' => mb_strtolower($name)]);

        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }
}
