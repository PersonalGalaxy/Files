<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Command\TrashFolder,
    Repository\FolderRepository,
};

final class TrashFolderHandler
{
    private $repository;

    public function __construct(FolderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(TrashFolder $wished): void
    {
        $this
            ->repository
            ->get($wished->identity())
            ->trash();
    }
}
