<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Exception;

use DomainException;

class EmailAlreadyRegistered extends DomainException
{
    public static function fromEmail(string $email) : self
    {
        return new self(sprintf("O email '%s' já foi cadastrado.", $email));
    }
}