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
        //$allGenre = $this->getAllGenreMovie();

        //get all movie by genre
        $listMovies = $this->getMoviesByGenre(28);//dd($listMovies);

        //get detail of one movie
        $oneMovie = $this->getMovieDetails(1007401);

        //get the top movie
        $topMovie = MovieUtils::getTopMovie($listMovies);

        //get list of all movie
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'topMovie' =>$topMovie,
            'listMovies' => $listMovies,
        ]);
    }


    public function getAllGenreMovie()
    {
        $result = $this->theMovieDatabase->getAllGenreMovie();
        return $result;
    }

    public function getMoviesByGenre(int $idGenre)
    {
        $result = $this->theMovieDatabase->getMoviesByGenre($idGenre);
        return $result;
    }

    public function getMovieDetails(int $idMovie)
    {
        $result = $this->theMovieDatabase->getMovieDetails($idMovie);
        return $result;
    }
}
