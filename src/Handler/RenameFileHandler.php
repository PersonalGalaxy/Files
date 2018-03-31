<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Command\RenameFile,
    Repository\FileRepository,
};

final class RenameFileHandler
{
    private $repository;

    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RenameFile $wished): void
    {
        $this
            ->repository
            ->get($wished->identity())
            ->rename($wished->name());
    }
}
