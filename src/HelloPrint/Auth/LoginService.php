<?php declare(strict_types=1);

namespace App\HelloPrint\Auth;

use App\HelloPrint\Auth\Exception\ServiceUnavailableException;
use App\HelloPrint\Auth\Exception\UserNotFoundException;

class LoginService
{
    private Authenticator $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * @throws ServiceUnavailableException
     * @throws UserNotFoundException
     */
    public function doLogin(string $email, string $password): User
    {
        return $this->authenticator->authenticate($email, $password);
    }
}
