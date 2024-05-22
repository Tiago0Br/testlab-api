<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Enum;

enum TestCaseStatusType: string
{
    case NotExecuted = 'NÃO EXECUTADO';
    case Pass = 'PASSOU';
    case Fail = 'COM FALHA';
    case Blocked = 'BLOQUEADO';
    case Executing = 'EM EXECUÇÃO';
    case Cancelled = 'CANCELADO';
    case Available = 'LIBERADO';

    public static function toArray(): array
    {
        return array_column(TestCaseStatusType::cases(), 'value');
    }

    public static function statusExists(string $status): bool
    {
        return in_array($status, TestCaseStatusType::toArray());
    }
}