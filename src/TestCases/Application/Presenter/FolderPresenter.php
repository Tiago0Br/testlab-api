<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Application\Presenter;

class FolderPresenter
{
    public static function format(array $folder): array
    {
        unset($folder['project']['owner_user']);

        return [
            'id' => $folder['id'],
            'title' => $folder['title'],
            'project' => $folder['project'],
            'folder' => $folder['folder'] ? [
                'id' => $folder['folder']['id'],
                'title' => $folder['folder']['title'],
            ] : null,
            'is_test_suite' => $folder['is_test_suite']
        ];
    }
}