<?php declare(strict_types=1);

namespace App\Repository\AuthenticationService;

use App\HelloPrint\Entity\User;
use App\HelloPrint\Service\Authentication\UserLoader;
use GuzzleHttp\Client as GuzzleClient;

class ApiUserLoader implements UserLoader
{
    public function loadByEmail(string $email): ?User
    {
        $client = new GuzzleClient(['base_url' => 'https://github.com']);
        // TODO: Implement loadByEmail() method.
    }
}
