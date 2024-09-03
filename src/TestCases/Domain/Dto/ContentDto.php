<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Troupe\TestlabApi\TestCases\Application\Presenter\FolderPresenter;
use Troupe\TestlabApi\TestCases\Application\Presenter\TestCasePresenter;
use Troupe\TestlabApi\TestCases\Domain\Entity\Folder;
use Troupe\TestlabApi\TestCases\Domain\Entity\TestCase;

class ContentDto
{
    private function __construct(
        public readonly ?Folder $parentFolder,
        /** @var Folder[] $folders */
        public readonly array $folders,
        /** @var TestCase[] $testCases */
        public readonly array $testCases
    ) {
    }

    public static function populate(array $params): self
    {
        return new self(
            parentFolder: $params['parent_folder'] ?? null,
            folders: $params['folders'],
            testCases: $params['test_cases']
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'parent_folder' => $this->parentFolder ?
                FolderPresenter::onlyFolderData($this->parentFolder->jsonSerialize()) :
                null,
            'folders' => array_map(fn(Folder $folder) =>
                FolderPresenter::onlyFolderData($folder->jsonSerialize()),
                $this->folders
            ),
            'test_cases' => array_map(fn(TestCase $testCase) =>
                TestCasePresenter::onlyTestCaseData($testCase->jsonSerialize()),
                $this->testCases
            ),
        ];
    }
}