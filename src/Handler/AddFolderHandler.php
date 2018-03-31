<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Command\AddFolder,
    Repository\FolderRepository,
    Entity\Folder,
    Exception\FolderNotFound,
};

final class AddFolderHandler
{
    private $repository;

    public function __construct(FolderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddFolder $wished): void
    {
        if (!$this->repository->has($wished->parent())) {
            throw new FolderNotFound($wished->parent());
        }

        $this->repository->add(
            Folder::add(
                $wished->identity(),
                $wished->name(),
                $wished->parent()
            )
        );
    }
}
