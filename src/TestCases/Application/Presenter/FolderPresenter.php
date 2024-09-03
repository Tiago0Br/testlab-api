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
            'parent_folder' => $folder['parent_folder'] ? [
                'id' => $folder['parent_folder']['id'],
                'title' => $folder['parent_folder']['title'],
            ] : null,
        ];
    }

    public static function onlyFolderData(array $folder): array
    {
        $content = self::format($folder);
        unset($content['project'], $content['parent_folder']);

        return $content;
    }
}