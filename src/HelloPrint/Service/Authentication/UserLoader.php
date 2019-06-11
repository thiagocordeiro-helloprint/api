<?php declare(strict_types=1);

namespace App\HelloPrint\Service\Authentication;

use App\HelloPrint\Entity\User;

interface UserLoader
{
    public function loadByEmail(string $email): ?User;
}
