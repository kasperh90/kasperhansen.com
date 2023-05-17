<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Admin;

use App\Controller\Admin\MainController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class MainControllerTest extends WebTestCase
{

    public function testIfIndexReturnsASuccessfulResponse(): void
    {

        $client = static::createClient();

        $client->request(
            method: 'GET',
            uri: '/',
            server: ['HTTP_HOST' => 'admin.' . $_ENV['BASE_HOST']]
        );

        $message = "Index did not return OK";
        $condition = $client->getResponse()->getStatusCode() === Response::HTTP_OK;
        $this->assertTrue($condition, $message);

        $message = "Index did not return a response with UTF-8 charset";
        $condition = $client->getResponse()->getCharset() === 'UTF-8';
        $this->assertTrue($condition, $message);

    }

}