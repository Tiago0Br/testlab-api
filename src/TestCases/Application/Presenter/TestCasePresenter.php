<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Application\Presenter;

class TestCasePresenter
{
    public static function format(array $testCase): array
    {
        return [
            'id' => $testCase['id'],
            'title' => $testCase['title'],
            'summary' => $testCase['summary'],
            'preconditions' => $testCase['preconditions'],
            'status' => $testCase['status'],
            'test_suite' => [
                'id' => $testCase['test_suite']['id'],
                'title' => $testCase['test_suite']['title'],
                'project' => [
                    'id' => $testCase['test_suite']['project']['id'],
                    'name' => $testCase['test_suite']['project']['name'],
                ]
            ]
        ];
    }

    public static function onlyTestCaseData(array $testCase): array
    {
        $content = self::format($testCase);
        $content['status'] = $testCase['status'][0];
        unset($content['test_suite']);

        return $content;
    }
}