<?php declare(strict_types=1);

namespace App\Tests\HelloPrint\Service\Authentication;

use App\HelloPrint\Entity\User;
use App\HelloPrint\Exception\UserNotFoundByEmailException;
use App\HelloPrint\Service\Authentication\PasswordResetLinkCreator;
use App\HelloPrint\Service\Authentication\ResetPassword;
use App\HelloPrint\Service\Authentication\UserLoader;
use App\HelloPrint\Service\UuidCreator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ResetPasswordTest extends TestCase
{
    /** @var MockObject */
    private UuidCreator $uuidCreator;

    /** @var MockObject */
    private PasswordResetLinkCreator $passwordResetLinkCreator;

    /** @var MockObject */
    private UserLoader $userLoader;

    private ResetPassword $service;

    protected function setUp(): void
    {
        $this->uuidCreator = $this->createMock(UuidCreator::class);
        $this->passwordResetLinkCreator = $this->createMock(PasswordResetLinkCreator::class);
        $this->userLoader = $this->createMock(UserLoader::class);

        $this->service = new ResetPassword(
            $this->uuidCreator,
            $this->passwordResetLinkCreator,
            $this->userLoader
        );
    }

    public function testShouldReturnOwnUuid(): void
    {
        $uuid = '1111-2222-3333-4444-5555-6666';
        $email = 'user@helloprint.nl';
        $this->uuidCreator->method('create')->willReturn($uuid);
        $this->userLoader->method('loadByEmail')->willReturn(new User('123-abc', $email));

        $result = $this->service->reset('user@helloprint.nl');

        $this->assertEquals($uuid, $result);
    }

    public function testWhenServiceCantFindUserByEmailThenThrowUserNotFountError(): void
    {
        $this->expectException(UserNotFoundByEmailException::class);

        $this->service->reset('no-reply@helloprint.nl');
    }
}
