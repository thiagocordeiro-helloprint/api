<?php declare(strict_types=1);

namespace App\Tests\HelloPrint\Service\Authentication;

use App\HelloPrint\Service\Authentication\PasswordResetLinkCreator;
use App\HelloPrint\Service\Authentication\ResetPassword;
use App\HelloPrint\Service\UuidCreator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ResetPasswordTest extends TestCase
{
    /** @var MockObject */
    private UuidCreator $uuidCreator;

    /** @var MockObject */
    private PasswordResetLinkCreator $passwordResetLinkCreator;

    private ResetPassword $reseter;

    protected function setUp(): void
    {
        $this->uuidCreator = $this->createMock(UuidCreator::class);
        $this->passwordResetLinkCreator = $this->createMock(PasswordResetLinkCreator::class);

        $this->reseter = new ResetPassword($this->uuidCreator, $this->passwordResetLinkCreator);
    }

    public function testShouldReturnOwnUuid(): void
    {
        $uuid = '1111-2222-3333-4444-5555-6666';
        $this->uuidCreator->method('create')->willReturn($uuid);

        $result = $this->reseter->reset('user@helloprint.nl');

        $this->assertEquals($uuid, $result);
    }
}
