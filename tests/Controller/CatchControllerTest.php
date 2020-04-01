<?php

namespace App\Tests\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class CatchControllerTest extends WebTestCase
{

  //INDEX TEST
    public function testIndex()
    {
      $client = static::createClient();

      $crawler = $client->request(
          'GET',
          '/catch/'
          );

      $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }


    //REGISTRATION TEST
    public function testCatch_registration()
    {
        $client = static::createClient();

        $crawler = $client->request(
            'POST',
            '/catch/catch_registration',
            array(
                "login"        => '+7(666)666-66-66',
                "password"        => '123',
                "email"           => "limbo@mail.ru",
                "phone" => "+7(666)666-66-66",
                "type" => "1",
                "full_name" => "Веб Гай Тестович",
                "inn" => '666666666666',
                'kpp' => '666666666',
                'jur_name' => '666',
                'jur_address' => 'Saint-P',
                'fiz_address' => 'Saint-P',
                'tester_id' => '1',
              )
            );

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    //LOGIN TEST
    public function testCatch_login()
    {
        $client = static::createClient();

        $crawler = $client->request(
            'POST',
            '/catch/catch_login',
            array(
                "login"        => '+7(666)666-66-66',
                "password"        => '666',
                'tester_id' => '1',
              )
            );

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    //EVENT TEST
    // public function testCatch_event()
    // {
    //     $client = static::createClient();
    //
    //     $crawler = $client->request(
    //         'POST',
    //         '/catch/catch_event',
    //         array(
    //             "tester_id"         => 1,
    //             "event_name"        => 'test_event',
    //             "event_type"        => 1,
    //             "event_way"         => json_decode('[{"id": "1"}]'),
    //             "event_address"     => 'test',
    //             "event_start_time"  => '2019-09-30 11:56:35',
    //             "event_end_time"    => '2019-09-30 11:56:35',
    //             "lector_id"         => json_decode('[{"id": "1"}, {"id": "2"}]'),
    //             "event_photos"      => json_decode('[{"src": "/img/events/photo/1.jpg"}, {"src": "/img/events/photo/2.jpg"}]'),
    //             "event_description" => 'TESTOVOE',
    //             "is_free"           => 0,
    //             "price"             => 2000,
    //             "is_discount"       => 0,
    //             "rule_point"        => 0,
    //             "rule_sertificate"  => 0,
    //             "event_main_img"    => '/img/events/photo/1.jpg'
    //           )
    //         );
    //
    //     $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    // }

    //LECTOR TEST
    // public function testCatch_lector()
    // {
    //     $client = static::createClient();
    //
    //     $crawler = $client->request(
    //         'POST',
    //         '/catch/catch_lector',
    //         array(
    //             "full_name"         => 'Тестовый Лектор Лекторович',
    //             "worker_position"   => 'Тестировщик',
    //             "phone"             => '8-812-999-88-77',
    //             "email"             => 'mail@mail.mail',
    //             "photo"             => '/img/lectors/photos/test.photo.png'
    //           )
    //         );
    //
    //     $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    // }

}
