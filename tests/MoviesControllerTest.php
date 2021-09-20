<?php

namespace App\Tests;

use App\Entity\Movie;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoviesControllerTest extends WebTestCase
{

    private $client;
    /**
     * @var EntityManager
     */
    private $em;
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->client = static::createClient();
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')->getManager();
    }

    public function testIndex()
    {
        // Request home page
        $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Upcoming Movies');
    }

    public function testView()
    {
        $movie = $this->em
            ->getRepository(Movie::class)
            ->findOneBy(['title' => 'Luca']);

        $this->assertSame('PG V', $movie->getAgeRestriction());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->em->close();
        $this->em = null;
    }
}