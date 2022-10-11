<?php

namespace App\Controller;

use App\Service\MovieInterface;
use App\Service\MovieUtils;
use App\Service\TheMovieDatabase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private TheMovieDatabase $theMovieDatabase;


    public function __construct(TheMovieDatabase $theMovieDatabase)
    {
        $this->theMovieDatabase = $theMovieDatabase;
    }

    #[Route('/', name: 'homePage')]
    public function index(): Response
    {
        //load genre movie
        $allGenre = $this->theMovieDatabase->getAllGenreMovie();

        //Get random genre
        $allGenreId= array_map(function($genre){return $genre->getId();},$allGenre);
        shuffle($allGenreId);
        $randomIdGenre = $allGenreId[array_key_first($allGenreId)];

        //get all movie by genre
        $listMovies = $this->theMovieDatabase->getMoviesByGenre($randomIdGenre);

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

    #[Route(path: '/topMovie/{idGenre}', name: 'topMovie', methods: ['GET'])]
    public function getTopMovie(int $idGenre)
    {
        $listMovies = $this->theMovieDatabase->getMoviesByGenre($idGenre);
        $result = MovieUtils::getTopMovie($listMovies);

        return $this->render('include/topMovie.html.twig', [
            'controller_name' => 'DefaultController',
            'topMovie' =>$result,
        ]);
    }

    #[Route(path: '/moviesByGenre/{idGenre}', name: 'moviesByGenre', methods: ['GET'])]
    public function getMoviesByGenre(int $idGenre)
    {
        $listMovies = $this->theMovieDatabase->getMoviesByGenre($idGenre);

        return $this->render('include/listMovies.html.twig', [
            'listMovies' =>$listMovies,
        ]);
    }

    #[Route(path: '/detailMovie/{idMovie}', name: 'detailMovie', methods: ['GET'])]
    public function getMovieDetails(int $idMovie)
    {
        $movie = $this->theMovieDatabase->getMovieDetails($idMovie);
        return $this->render('modal/detailMovie.html.twig', [
            'movie' =>$movie,
        ]);
    }

    #[Route(path: '/findMovie/{movieToFind}', name: 'movieToFind', methods: ['GET'])]
    public function findMovie(string $movieToFind){
        $listMovies = $this->theMovieDatabase->findMovie($movieToFind);

        return $this->render('include/listMovies.html.twig', [
            'listMovies' =>$listMovies,
            'resultNumber'=>count($listMovies),
            'movieToFind'=>$movieToFind
        ]);
    }
}
