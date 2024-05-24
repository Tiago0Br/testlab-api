<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Application\Auth;

class HeaderToken
{
    private const string TOKEN_HEADER_NAME = 'Authorization';

    public static function get(): string
    {
        $authorization = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
        if ('' !== $authorization) {
            return str_replace('Bearer ', '', $authorization);
        }

        $headers = function_exists('getallheaders')
            ? getallheaders()
            : self::getAllHeaders();

        $headers = self::arrayKeyStrToLower((array) $headers);

        return $headers[strtolower(self::TOKEN_HEADER_NAME)] ?? '';
    }

    private static function getAllHeaders(): array
    {
        if (! is_array($_SERVER)) {
            return [];
        }

        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (str_starts_with($name, 'HTTP_')) {
                $headerKey           = str_replace(['_', ' '], [' ', '-'], substr($name, 5));
                $headers[$headerKey] = $value;
            }
        }

        return $headers;
    }

    private static function arrayKeyStrToLower(array $arr): array
    {
        $arrStrToLower = [];
        foreach ($arr as $key => $item) {
            $arrStrToLower[strtolower($key)] = $item;
        }
        return $arrStrToLower;
    }
}