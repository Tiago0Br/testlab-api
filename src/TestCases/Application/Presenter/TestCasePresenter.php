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
            'test_suite' => FolderPresenter::onlyFolderData($testCase['test_suite']),
            'status' => $testCase['status'][0],
            'history' => $testCase['status'],
        ];
    }

    public static function onlyTestCaseData(array $testCase): array
    {
        $content = self::format($testCase);
        unset($content['history'], $content['test_suite']);

        return $content;
    }
}