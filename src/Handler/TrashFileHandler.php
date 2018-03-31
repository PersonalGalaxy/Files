<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Command\TrashFile,
    Repository\FileRepository,
};

final class TrashFileHandler
{
    private $repository;

    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(TrashFile $wished): void
    {
        $this
            ->repository
            ->get($wished->identity())
            ->trash();
    }
}
