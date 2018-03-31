<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Repository\FileRepository,
    Repository\FolderRepository,
    Command\RemoveFile,
    Command\RemoveFolder,
    Entity\File,
    Entity\Folder,
    Specification\Trashed,
};

final class EmptyTrashHandler
{
    private $files;
    private $folders;
    private $removeFile;
    private $removeFolder;

    public function __construct(
        FileRepository $files,
        FolderRepository $folders,
        RemoveFileHandler $removeFile,
        RemoveFolderHandler $removeFolder
    ) {
        $this->files = $files;
        $this->folders = $folders;
        $this->removeFile = $removeFile;
        $this->removeFolder = $removeFolder;
    }

    public function __invoke(): void
    {
        $this
            ->folders
            ->matching(new Trashed)
            ->foreach(function(Folder $folder): void {
                ($this->removeFolder)(new RemoveFolder($folder->identity()));
            });
        $this
            ->files
            ->matching(new Trashed)
            ->foreach(function(File $file): void {
                ($this->removeFile)(new RemoveFile($file->identity()));
            });
    }
}
