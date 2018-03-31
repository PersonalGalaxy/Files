<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Command\RemoveFolder,
    Command\RemoveFile,
    Repository\FileRepository,
    Repository\FolderRepository,
    Entity\Folder,
    Entity\File,
    Specification\ParentFolder,
    Specification\FileFolder,
};

final class RemoveFolderHandler
{
    private $files;
    private $folders;
    private $removeFile;

    public function __construct(
        FileRepository $files,
        FolderRepository $folders,
        RemoveFileHandler $removeFile
    ) {
        $this->files = $files;
        $this->folders = $folders;
        $this->removeFile = $removeFile;
    }

    public function __invoke(RemoveFolder $wished): void
    {
        $folder = $this->folders->get($wished->identity());
        $folder->remove();

        $this
            ->folders
            ->matching(new ParentFolder($wished->identity()))
            ->foreach(function(Folder $folder): void {
                $folder->trash();
                $this(new RemoveFolder($folder->identity()));
            });
        $this
            ->files
            ->matching(new FileFolder($wished->identity()))
            ->foreach(function(File $file): void {
                $file->trash();
                ($this->removeFile)(new RemoveFile($file->identity()));
            });

        $this->folders->remove($folder->identity());
    }
}
