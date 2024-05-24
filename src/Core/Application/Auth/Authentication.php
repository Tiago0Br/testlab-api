<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Application\Auth;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Troupe\TestlabApi\Core\Domain\Entity\User;
use Troupe\TestlabApi\Core\Domain\Exception\InvalidToken;

class Authentication
{
    public function __construct(
        private readonly Configuration $config
    ) {
    }

    public function generateToken(User $user): string
    {
        return $this->config->builder()
            ->issuedBy('testlab')
            ->identifiedBy((string) $user->getId())
            ->permittedFor('testlab')
            ->getToken($this->config->signer(), $this->config->signingKey())
            ->toString();
    }

    public function authenticate(string $inputToken): int
    {
        if (trim($inputToken) === '') {
            throw InvalidToken::create();
        }

        $token = $this->config->parser()->parse($inputToken);
        $this->config->setValidationConstraints(new SignedWith($this->config->signer(), $this->config->signingKey()));

        if (! $this->config->validator()->validate($token, ...$this->config->validationConstraints())) {
            throw InvalidToken::create();
        }

        return (int) $token->claims()->get('jti');
    }
}