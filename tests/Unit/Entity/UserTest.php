<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use Generator;
use Monolog\Test\TestCase;

class UserTest extends TestCase
{

    /**
     * @dataProvider userDataProvider
     */
    public function testUserGettersAndSetters(
        string $email,
        string $password,
        array  $roles,
        int    $numberOfRoles): void
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles($roles);

        $this->assertSame($email, $user->getEmail());
        $this->assertSame($password, $user->getPassword());
        $this->assertTrue(count($user->getRoles()) === $numberOfRoles);
    }

    public function userDataProvider(): Generator
    {
        yield ['test@kasperhansen.com', 'eiufghy38tf87w7', [], 1];
        yield ['*#/)(/=', '&)/&(&(', ['ROLE_ADMIN'], 2];
    }

}