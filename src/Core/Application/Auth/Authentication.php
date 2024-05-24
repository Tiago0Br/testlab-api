<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Application\Auth;

use DateInterval;
use DateTimeImmutable;
use Exception;
use Lcobucci\JWT\Configuration;
use Troupe\TestlabApi\Core\Domain\Entity\User;

class Authentication
{
    public function __construct(
        private readonly Configuration $configuration,
        private readonly int $timeExpirationSeconds
    ) {
    }

    /**
     * @throws Exception
     */
    public function generateToken(User $user): string
    {
        $expirationDate = new DateTimeImmutable();

        return $this->configuration->builder()
            ->identifiedBy((string) $user->getId())
            ->expiresAt($expirationDate->add(new DateInterval(sprintf('PT%sS', $this->timeExpirationSeconds))))
            ->getToken($this->configuration->signer(), $this->configuration->signingKey())
            ->toString();
    }
}