<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Command\MoveFolder,
    Repository\FolderRepository,
    Exception\FolderNotFound,
};

final class MoveFolderHandler
{
    private $repository;

    public function __construct(FolderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(MoveFolder $wished): void
    {
        if (!$this->repository->has($wished->parent())) {
            throw new FolderNotFound($wished->parent());
        }

        $this
            ->repository
            ->get($wished->identity())
            ->moveTo($wished->parent());
    }
}
