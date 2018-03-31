<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Command\RestoreFile,
    Repository\FileRepository,
};

final class RestoreFileHandler
{
    private $repository;

    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RestoreFile $wished): void
    {
        $this
            ->repository
            ->get($wished->identity())
            ->restore();
    }
}
