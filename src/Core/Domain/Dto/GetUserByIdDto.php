<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Dto;

use Assert\Assert;

class GetUserByIdDto
{
    private function __construct(public readonly int $id)
    {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            id: (int) $params['id']
        );
    }

    private static function validate(array $params): void
    {
        Assert::that($params['id'])
            ->notNull("O campo 'id' é obrigatório")
            ->integerish("O campo 'id' deve ser um número");
    }
}