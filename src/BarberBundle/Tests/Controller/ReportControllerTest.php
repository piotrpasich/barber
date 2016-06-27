<?php

namespace BarberBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReportControllerTest extends WebTestCase
{
    public function testToday()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/today');
    }

    public function testPeriod()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/period');
    }

}
