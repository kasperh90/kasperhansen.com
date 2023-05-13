<?php

declare(strict_types=1);

namespace App\Tests\Controller\Www;

use App\Controller\Www\HomeController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{

    private string $controllerName;
    private string $controllerFile;
    private string $controllerClass;

    public function setUp(): void
    {

        $this->controllerName = 'HomeController';
        $this->controllerFile = __DIR__ . "/../../../src/Controller/Www/{$this->controllerName}.php";
        $this->controllerClass = HomeController::class;

    }

    public function testIfClassExists(): void
    {

        $message = "{$this->controllerName} does not exist";
        $this->assertFileExists($this->controllerFile, $message);

    }

    public function testIfExtendsAbstractController(): void
    {

        $message = "{$this->controllerName} does not inherit from AbstractController";
        $this->assertInstanceOf(AbstractController::class, new $this->controllerClass(), $message);

    }

    public function testIfHasIndexMethod(): void
    {

        $condition = method_exists(new $this->controllerClass, 'index');
        $message = "{$this->controllerName} does not have a method called index";
        $this->assertTrue($condition, $message);

    }

    public function testIfIndexReturnsASuccessfulResponse(): void
    {

        $client = static::createClient();

        $client->request(
            method: 'GET',
            uri: '/',
            server: ['HTTP_HOST' => 'www.' . $_ENV['BASE_HOST']]
        );

        $message = "Index did not return OK";
        $condition = $client->getResponse()->getStatusCode() === Response::HTTP_OK;
        $this->assertTrue($condition, $message);

        $message = "Index did not return a response with UTF-8 charset";
        $condition = $client->getResponse()->getCharset() === 'UTF-8';
        $this->assertTrue($condition, $message);

    }

}