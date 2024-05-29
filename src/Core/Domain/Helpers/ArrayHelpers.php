<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Helpers;

class ArrayHelpers
{
    public static function changeValue(array $params, string $key, mixed $value): array
    {
        return array_merge($params, [$key => $value]);
    }
}