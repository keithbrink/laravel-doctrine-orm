<?php

namespace LaravelDoctrineTest\ORM\Assets\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "LaravelDoctrineTest\ORM\Assets\Repository\TheoryRepository")]
class Theory
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\Column(type: "string", nullable: false)]
    private $title;

    #[ORM\ManyToOne(targetEntity: \Scientist::class, inversedBy: "theories")]
    #[ORM\JoinColumn(name: "scientist_id", referencedColumnName: "id", nullable: false)]
    private $scientist;
}
