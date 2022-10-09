<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;

class Movie
{
    private $id;

    private $title;

    private $releaseDate;

    private $productionName;

    private $description;

    private $voteCount;

    /**
     * @return mixed
     */
    public function getVoteCount()
    {
        return $this->voteCount;
    }

    /**
     * @param mixed $voteCount
     */
    public function setVoteCount($voteCount): void
    {
        $this->voteCount = $voteCount;
    }

    private $voteAverage;

    private $numberUserVoting;

    private $urlVideo;

    private $thumbnail;

    private $originalLanguage;

    /**
     * @return mixed
     */
    public function getOriginalLanguage()
    {
        return $this->originalLanguage;
    }

    /**
     * @param mixed $originalLanguage
     */
    public function setOriginalLanguage($originalLanguage): void
    {
        $this->originalLanguage = $originalLanguage;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Movie constructor.
     * @param $id
     * @param $title
     * @param $releaseDate
     * @param $productionName
     * @param $description
     * @param $voteAverage
     * @param $numberUserVoting
     */



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getProductionName(): ?string
    {
        return $this->productionName;
    }

    public function setProductionName(?string $productionName): self
    {
        $this->productionName = $productionName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getVoteAverage(): ?float
    {
        return $this->voteAverage;
    }

    public function setVoteAverage(?float $voteAverage): self
    {
        $this->voteAverage = $voteAverage;

        return $this;
    }

    public function getNumberUserVoting(): ?int
    {
        return $this->numberUserVoting;
    }

    public function setNumberUserVoting(?int $numberUserVoting): self
    {
        $this->numberUserVoting = $numberUserVoting;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrlVideo()
    {
        return $this->urlVideo;
    }

    /**
     * @param mixed $urlVideo
     */
    public function setUrlVideo($urlVideo): void
    {
        $this->urlVideo = $urlVideo;
    }

    public function __toArray(){
        return [
              'id'=>$this->id,
            'title'=>$this->title,
            'releaseDate'=> $this->releaseDate->format('Y'),
            'productionName'=>$this->productionName,
            'description'=>$this->description,
            'voteAverage'=>$this->voteAverage,
            'voteCount'=>$this->voteCount,
            'numberUserVoting'=>$this->numberUserVoting,
            'urlVideo'=>$this->urlVideo,
            'thumbnail'=>$this->thumbnail,
            'originalLanguage'=>$this->originalLanguage,
        ];
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param mixed $thumbnail
     */
    public function setThumbnail($thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

}
