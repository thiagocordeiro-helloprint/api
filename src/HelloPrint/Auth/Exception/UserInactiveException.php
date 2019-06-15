<?php declare(strict_types=1);

namespace App\HelloPrint\Auth\Exception;

use App\HelloPrint\Exception\DomainException;
use Throwable;

class UserInactiveException extends DomainException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('', 0, $previous);
    }
}
