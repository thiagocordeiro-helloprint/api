<?php declare(strict_types=1);

namespace App\Infra\Service;

use App\HelloPrint\Auth\Authenticator;
use App\HelloPrint\Auth\Exception\PasswordMismatchException;
use App\HelloPrint\Auth\Exception\ServiceUnavailableException;
use App\HelloPrint\Auth\Exception\UserInactiveException;
use App\HelloPrint\Auth\Exception\UserNotFoundException;
use App\HelloPrint\Auth\PasswordReseter;
use App\HelloPrint\Auth\User;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Symfony\Component\HttpFoundation\Response;

class GuzzleApiClient implements PasswordReseter, Authenticator
{
    private GuzzleClient $guzzle;

    public function __construct(GuzzleClient $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * @throws ServiceUnavailableException
     * @throws UserNotFoundException
     */
    public function resetPassword(string $email): void
    {
        try {
            $this->guzzle->post("api/users/password-reset", [
                RequestOptions::JSON => [
                    'email' => $email,
                ],
            ]);
        } catch (ClientException $e) {
            $this->throwRequestError($e);
        }
    }

    /**
     * @throws ServiceUnavailableException
     * @throws UserNotFoundException
     * @throws PasswordMismatchException
     * @throws UserInactiveException
     */
    public function authenticate(string $email, string $password): ?User
    {
        try {
            $response = $this->guzzle->post('api/users/login', [
                RequestOptions::JSON => [
                    'email' => $email,
                    'password' => $password,
                ],
            ]);

            $data = json_decode((string) $response->getBody(), true);

            return new User(
                (string) $data['username'] ?? '',
                (string) $data['email'] ?? ''
            );
        } catch (ClientException $e) {
            $this->throwRequestError($e);
        }

        return null;
    }

    /**
     * @throws ServiceUnavailableException
     * @throws UserNotFoundException
     * @throws PasswordMismatchException
     * @throws UserInactiveException
     */
    private function throwRequestError(ClientException $e): void
    {
        if ($e->getCode() === Response::HTTP_NOT_FOUND) {
            throw new UserNotFoundException();
        }

        if ($e->getCode() === Response::HTTP_UNAUTHORIZED) {
            throw new PasswordMismatchException();
        }

        if ($e->getCode() === Response::HTTP_FORBIDDEN) {
            throw new UserInactiveException();
        }

        throw new ServiceUnavailableException($e);
    }
}
