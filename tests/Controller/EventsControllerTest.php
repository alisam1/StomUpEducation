<?php

namespace App\Tests\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class EventsControllerTest extends WebTestCase
{

  //INDEX TEST
    public function testIndex()
    {
      $client = static::createClient();

      $crawler = $client->request(
          'GET',
          '/events'
          );

      $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }



}
