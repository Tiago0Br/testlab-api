<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Helpers;

use Assert\Assert;

class ParamsValidator
{
    private function __construct(public readonly array $params)
    {
    }

    public static function fromArray(array $params): self
    {
        return new self($params);
    }

    public function validateInteger(array $fields, bool $required=true): self
    {
        array_map(function ($key) use ($required) {
            if ($required) {
                Assert::that($this->params[$key])
                    ->notNull("O campo '$key' é obrigatório");
            }

            if (!$required && !isset($this->params[$key])) {
                return;
            }

            Assert::that($this->params[$key])
                ->integerish("O campo '$key' deve ser um número");
        }, $fields);

        return $this;
    }

    public function validateString(array $fields, bool $required=true): self
    {
        array_map(function ($key) use ($required) {
            if ($required) {
                Assert::that($this->params[$key])
                    ->notNull("O campo '$key' é obrigatório");
            }

            if (!$required && !isset($this->params[$key])) {
                return;
            }

            Assert::that($this->params[$key])
                ->string("O campo '$key' deve ser do tipo string")
                ->notEmpty("O campo '$key' não pode ser vazio");
        }, $fields);

        return $this;
    }
}