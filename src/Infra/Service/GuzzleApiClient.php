<?php declare(strict_types=1);

namespace App\Infra\Service;

use App\HelloPrint\Auth\AuthApi;
use App\HelloPrint\Auth\Exception\ServiceUnavailableException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class GuzzleApiClient implements AuthApi
{
    private GuzzleClient $guzzle;

    public function __construct(GuzzleClient $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function resetPassword(string $email): void
    {
        try {
            $this->guzzle->post("api/users/{$email}/password-reset");
        } catch (ClientException $e) {
            throw new ServiceUnavailableException($e);
        }
    }
}
