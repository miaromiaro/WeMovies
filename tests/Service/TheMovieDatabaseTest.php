<?php
namespace App\Test\Service;

use App\Service\MovieInterface;
use PHPUnit\Framework\TestCase;

class TheMovieDatabaseTest extends TestCase implements MovieInterface
{
    public function testGettingAllGenre()
    {
        $result = 42;
        $this->assertEquals(42,$result);
    }

    public function getAllGenreMovie()
    {
        $service = new TheMovieDatabaseTest();
        $this->assertIsArray();
    }

    public function getMoviesByGenre(int $idGenre)
    {
        // TODO: Implement getMoviesByGenre() method.
    }

    public function getMovieDetails(int $idMovie)
    {
        // TODO: Implement getMovieDetails() method.
    }
}