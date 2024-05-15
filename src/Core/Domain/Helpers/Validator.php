<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Helpers;

use Assert\Assert;

class Validator
{
    public static function validateInteger(array $params, array $fields, bool $required=true): void
    {
        array_map(static function ($key) use ($params, $required) {
            if ($required) {
                Assert::that($params[$key])
                    ->notNull("O campo '$key' é obrigatório");
            }

            if (!$required && !isset($params[$key])) {
                return;
            }

            Assert::that($params[$key])
                ->integerish("O campo '$key' deve ser um número");
        }, $fields);
    }

    public static function validateString(array $params, array $fields, bool $required=true): void
    {
        array_map(static function ($key) use ($params, $required) {
            if ($required) {
                Assert::that($params[$key])
                    ->notNull("O campo '$key' é obrigatório");
            }

            if (!$required && !isset($params[$key])) {
                return;
            }

            Assert::that($params[$key])
                ->string("O campo '$key' deve ser do tipo string")
                ->notEmpty("O campo '$key' não pode ser vazio");
        }, $fields);
    }
}