<?php declare(strict_types=1);

namespace App\Framework\Controller;

use App\HelloPrint\Auth\Exception\PasswordMismatchException;
use App\HelloPrint\Auth\Exception\ServiceUnavailableException;
use App\HelloPrint\Auth\Exception\UserInactiveException;
use App\HelloPrint\Auth\Exception\UserNotFoundException;
use App\HelloPrint\Auth\LoginService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginController
{
    private LoginService $service;

    public function __construct(LoginService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);
        $email = $body['email'] ?? '';
        $password = $body['password'] ?? '';

        if (!$email || !$password) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }

        try {
            $user = $this->service->doLogin($email, $password);
        } catch (PasswordMismatchException $e) {
            throw new HttpException(Response::HTTP_UNAUTHORIZED);
        } catch (UserInactiveException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN);
        } catch (UserNotFoundException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND);
        } catch (ServiceUnavailableException $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
        ]);
    }
}
