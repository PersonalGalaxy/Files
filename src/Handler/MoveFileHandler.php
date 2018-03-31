<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Command\MoveFile,
    Repository\FileRepository,
    Repository\FolderRepository,
    Exception\FolderNotFound,
};

final class MoveFileHandler
{
    private $files;
    private $folders;

    public function __construct(
        FileRepository $files,
        FolderRepository $folders
    ) {
        $this->files = $files;
        $this->folders = $folders;
    }

    public function __invoke(MoveFile $wished): void
    {
        if (!$this->folders->has($wished->folder())) {
            throw new FolderNotFound($wished->folder());
        }

        $this
            ->files
            ->get($wished->identity())
            ->moveTo($wished->folder());
    }
}
