<?php declare(strict_types=1);

namespace App\HelloPrint\Service;

interface UuidCreator
{
    public function create(): string;
}
