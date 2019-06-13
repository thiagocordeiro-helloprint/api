<?php declare(strict_types=1);

namespace App\Framework\Controller;

use App\HelloPrint\Auth\Exception\ServiceUnavailableException;
use App\HelloPrint\Auth\ResetPasswordService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RequestResetPasswordController
{
    private ResetPasswordService $resetPasswordService;

    public function __construct(ResetPasswordService $resetPasswordService)
    {
        $this->resetPasswordService = $resetPasswordService;
    }

    public function __invoke(Request $request): Response
    {
        $body = json_decode($request->getContent(), true);
        $email = $body['email'] ?? '';

        if (!$email) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->resetPasswordService->requestPasswordReset($email);
        } catch (ServiceUnavailableException $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response();
    }
}
