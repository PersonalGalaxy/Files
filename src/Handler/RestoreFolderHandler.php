<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Command\RestoreFolder,
    Repository\FolderRepository,
};

final class RestoreFolderHandler
{
    private $repository;

    public function __construct(FolderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RestoreFolder $wished): void
    {
        $this
            ->repository
            ->get($wished->identity())
            ->restore();
    }
}
