<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProutRepository")
 */
class Prout
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fff;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFff(): ?string
    {
        return $this->fff;
    }

    public function setFff(string $fff): self
    {
        $this->fff = $fff;

        return $this;
    }
}
