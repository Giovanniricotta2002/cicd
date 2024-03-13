<?php

namespace App\Entity;

use App\Repository\MathRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MathRepository::class)]
class Math
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: 'Vous devez saisir un nombre A.')]
    #[Assert\Type('integer')]
    private ?int $numberA;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: 'Vous devez saisir un nombre B.')]
    #[Assert\Type('integer')]
    private ?int $numberB;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberA(): ?int
    {
        return $this->numberA;
    }

    public function setNumberA(int $numberA): static
    {
        $this->numberA = $numberA;

        return $this;
    }

    public function getNumberB(): ?int
    {
        return $this->numberB;
    }

    public function setNumberB(int $numberB): static
    {
        $this->numberB = $numberB;

        return $this;
    }
}
