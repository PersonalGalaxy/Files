<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Command\AddFile,
    Entity\File,
    Entity\File\Name,
    Repository\FileRepository,
    Repository\FolderRepository,
    Exception\FolderNotFound,
};
use Innmind\Filesystem\{
    Adapter,
    File\File as RawFile,
};

final class AddFileHandler
{
    private $files;
    private $folders;
    private $filesystem;

    public function __construct(
        FileRepository $files,
        FolderRepository $folders,
        Adapter $filesystem
    ) {
        $this->files = $files;
        $this->folders = $folders;
        $this->filesystem = $filesystem;
    }

    public function __invoke(AddFile $wished): void
    {
        if (!$this->folders->has($wished->folder())) {
            throw new FolderNotFound($wished->folder());
        }

        $file = File::add(
            $wished->identity(),
            new Name((string) $wished->file()->name()),
            $wished->folder(),
            $wished->file()->mediaType()
        );
        $this->filesystem->add(new RawFile(
            (string) $wished->identity(),
            $wished->file()->content(),
            $wished->file()->mediaType()
        ));
        $this->files->add($file);
    }
}
