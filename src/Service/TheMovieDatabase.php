<?php


namespace App\Service;


use App\Entity\GenreMovie;
use App\Entity\Movie;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TheMovieDatabase implements MovieInterface
{
    /**
     * @var HttpClientInterface
     */
    private $client;
    /**
     * @var string
     */
    private $baseUrl;
    /**
     * @var KernelInterface
     */
    private $kernel;

    private $langageCode;

    private const API_ALL_GENRE = '/genre/movie/list';
    private const API_MOVIE_BY_GENRE  = '/discover/movie';
    private const URL_MOVIE_DETAIL = '/movie/[id_movie]';
    private const URL_VIDEO_MOVIE_DETAIL = '/movie/[id_movie]/videos';
    /**
     * @var MovieUtils
     */
    private $movieUtils;

    public function __construct(HttpClientInterface $client, KernelInterface $kernel,MovieUtils $movieUtils)
    {
        $this->client = $client;
        $this->kernel = $kernel;
        $this->baseUrl = $this->kernel->getContainer()->getParameter('app.url_api_tmdb');
        $this->langageCode = MovieUtils::languageCode($this->kernel->getContainer()->getParameter('app.tmdb_language'));
        $this->movieUtils = $movieUtils;
    }

    /**
     * @param string $urlEndPoint
     * @param array $criteria
     * @param string $method
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    private function requestToApi(string $urlEndPoint, array $criteria = [], string $method = 'GET'): array
    {
        $urlEndPoint = $this->kernel->getContainer()->getParameter('app.url_api_tmdb').$urlEndPoint;
        $criteria = [
            'query' => array_merge($criteria, ['api_key' => $this->kernel->getContainer()->getParameter('app.api_key_tmdb')])
        ];

        return $this->client->request($method, $urlEndPoint, $criteria)->toArray();
    }

    public function getAllGenreMovie():array
    {
        // Get all genre existing for movies to API TMDTB
        $response = $this->requestToApi(self::API_ALL_GENRE);

        $genresCollection = new ArrayCollection();
        foreach ($response['genres'] as $genres) {
            $genresCollection->add(new GenreMovie($genres['id'], $genres['name']));
        }
        return $genresCollection->toArray();
    }

    public function getMoviesByGenre(int $idGenre): array
    {
        //language argument
        $criteria['language'] = $this->langageCode;

        //Id Genre argument if exist
        if (!is_null($idGenre)) {
            $criteria['with_genres'] = $idGenre;
        }

        //Sort result by vote popularity desc
        $criteria['sort_by'] = "popularity.desc";

        //Sort with movie which have video
        $criteria['include_video'] = true;

        // Get list of movies by genre to API TMDTB
        $response = $this->requestToApi(self::API_MOVIE_BY_GENRE, $criteria);


        $moviesList = new ArrayCollection();

        foreach ($response['results'] as $movie) {
            //get video detail for each movie
            $moviesList->add($this->getMovieDetails($movie['id']));
        }

        // We return this collection sort by vote average
        return MovieUtils::sortMoviesByVoteAverage($moviesList);
    }

    public function getMovieDetails(int $idMovie):Movie
    {
        //language argument
        $criteria['language'] = $this->langageCode;

        // Get movie detail to API TMDTB
        $response = $this->requestToApi(str_replace('[id_movie]', $idMovie, self::URL_MOVIE_DETAIL), $criteria);
        $detailVideo = $this->getVideoMovieDetails($idMovie);
        $response = MovieUtils::DTOMovie($response,$detailVideo);

        return $response;
    }

    public function getVideoMovieDetails(int $idMovie): array
    {
        //language argument
        $criteria['language'] = $this->langageCode;

        // Get movie detail to API TMDTB
        $response = $this->requestToApi(str_replace('[id_movie]', $idMovie, self::URL_VIDEO_MOVIE_DETAIL), $criteria);

        //when no result, change language to default language (english) and retry request
        if(count($response['results'])<1){
            //language argument
            $criteria['language'] = MovieUtils::languageCode('english');

            // Get movie detail to API TMDTB
            $response = $this->requestToApi(str_replace('[id_movie]', $idMovie, self::URL_VIDEO_MOVIE_DETAIL), $criteria);
        }

        return $response;
    }
}