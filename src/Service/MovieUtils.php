<?php


namespace App\Service;

use App\Entity\Movie;
use Doctrine\Common\Collections\ArrayCollection;


class MovieUtils
{
    public static function languageCode(string $language){
        switch ($language){
            case "french":
                return "fr-FR";
                break;
            case "english":
                return "en-EN";
                break;
            default:
                return "fr-FR";
        }
    }

    public static function DTOMovie(array $movieFromApi, array $detailVideo):Movie
    {
        $movie = new Movie();
        if(is_array($movieFromApi)) {
            // id of movie
            $id = $movieFromApi['id'] ?? 0;

            //Title of movie
            $title = $movieFromApi['original_title'] ?? "";

            //Release date
            $releaseDate = new \DateTime($movieFromApi['release_date']) ?? "";

            //get production companies for getting production name
            if (count($movieFromApi['production_companies'])) {
                $arrayProductionName = array_map(function ($productionCompany) {
                    return $productionCompany['name'];
                }, $movieFromApi['production_companies']);
                $productionName = implode(",", array_unique($arrayProductionName));
            } else {
                $productionName = "";
            }

            //Description
            $description = $movieFromApi['overview'] ?? "";

            //Vote average
            $voteAverage = $movieFromApi['vote_average'] ?? 0;

            //Vote account
            $voteCount = $movieFromApi['vote_count'] ?? 0;

            //Get video url trailer
            $urlVideo = MovieUtils::getUrlTrailerMovie($detailVideo);

            //Get image for minature
            $thumbnail = "https://image.tmdb.org/t/p/original/".$movieFromApi['poster_path'];

            //Get original language
            $originalLanguage = $movieFromApi['original_language'] ?? 0;

            //Create object movie and return to array format
            $movie->setId($id);
            $movie->setTitle($title);
            $movie->setDescription($description);
            $movie->setReleaseDate($releaseDate);
            $movie->setProductionName($productionName);
            $movie->setVoteAverage($voteAverage);
            $movie->setVoteCount($voteCount);
            $movie->setUrlVideo($urlVideo);
            $movie->setThumbnail($thumbnail);
            $movie->setOriginalLanguage($originalLanguage);

        }
        return $movie;
    }

    public static function sortMoviesByVoteAverage(ArrayCollection $movieFromApi):array
    {
        // Sort collection by vote average of this movie
        $iterator = $movieFromApi->getIterator();
        $iterator->uasort(
        /**
         * @param Movie $first
         * @param Movie $second
         * @return int
         */ function ($first, $second) {
                return ($first->getVoteAverage() >= $second->getVoteAverage() ) ? -1 : 1;
            }
        );
        $listeMovieSorted = (new ArrayCollection(iterator_to_array($iterator)))->toArray();
        return array_values($listeMovieSorted);
    }

    public static function getTopMovie(array $listMovies):Movie
    {
        $movie = $listMovies[array_key_first($listMovies)];
        return $movie;
    }

    public static function getUrlTrailerMovie(array $detailMovieDetail):string
    {
        $url = "";
        if(is_array($detailMovieDetail)) {

            if (count($detailMovieDetail['results']) > 0) {
                foreach ($detailMovieDetail['results'] as $detail) {
                    if ($detail['type'] == 'Trailer') {
                        $url = "https://www.youtube.com/embed/" . $detail['key'];
                        break;
                    }
                }
            }
        }
        return $url;
    }
}