<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Command\RenameFolder,
    Repository\FolderRepository,
};

final class RenameFolderHandler
{
    private $repository;

    public function __construct(FolderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RenameFolder $wished): void
    {
        $this
            ->repository
            ->get($wished->identity())
            ->rename($wished->name());
    }
}
