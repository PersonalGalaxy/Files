<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Command\RemoveFile,
    Repository\FileRepository,
};
use Innmind\Filesystem\Adapter;

final class RemoveFileHandler
{
    private $repository;
    private $filesystem;

    public function __construct(
        FileRepository $repository,
        Adapter $filesystem
    ) {
        $this->repository = $repository;
        $this->filesystem = $filesystem;
    }

    public function __invoke(RemoveFile $wished): void
    {
        $file = $this->repository->get($wished->identity());
        $file->remove();

        $this->repository->remove($file->identity());
        $this->filesystem->remove((string) $file->name());
    }
}
