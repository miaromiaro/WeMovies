<?php

namespace App\Controller;

use App\Service\MovieInterface;
use App\Service\MovieUtils;
use App\Service\TheMovieDatabase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController implements MovieInterface
{

    /**
     * @var TheMovieDatabase
     */
    private $theMovieDatabase;


    public function __construct(TheMovieDatabase $theMovieDatabase)
    {
        $this->theMovieDatabase = $theMovieDatabase;
    }

    #[Route('/', name: 'homePage')]
    public function index(): Response
    {
        //load genre movie
        $allGenre = $this->getAllGenreMovie();

        //Get random genre
        $allGenreId= array_map(function($genre){return $genre->getId();},$allGenre);
        shuffle($allGenreId);
        $randomIdGenre = $allGenreId[array_key_first($allGenreId)];

        //get all movie by genre
        $listMovies = $this->theMovieDatabase->getMoviesByGenre($randomIdGenre);//dd($listMovies);

        //get the top movie
        $topMovie = MovieUtils::getTopMovie($listMovies);

        //get list of all movie
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'topMovie' =>$topMovie,
            'listMovies' => $listMovies,
            'allGenre' => $allGenre,
            'genreSelected' => $randomIdGenre,
        ]);
    }


    public function getAllGenreMovie()
    {
        $result = $this->theMovieDatabase->getAllGenreMovie();
        return $result;
    }
    
    #[Route(path: '/moviesByGenre', name: 'moviesByGenre', options: ['expose' => true])]
    public function getMoviesByGenre(int $idGenre)
    {
        $listMovies = $this->theMovieDatabase->getMoviesByGenre($idGenre);
        return $this->render('default/movieByGenre.twig', [
            'controller_name' => 'GetMoviesByScene',
            'listMovies' =>$listMovies,
        ]);
    }

    public function getMovieDetails(int $idMovie)
    {
        $result = $this->theMovieDatabase->getMovieDetails($idMovie);
        return $result;
    }
}
