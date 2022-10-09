<?php

namespace App\Entity;

use App\Repository\GenreMovieRepository;
use Doctrine\ORM\Mapping as ORM;

class GenreMovie
{

    private $id;

    private $name;

    /**
     * GenreMovie constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
