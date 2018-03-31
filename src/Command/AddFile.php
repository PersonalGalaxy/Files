<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\Entity\{
    File\Identity,
    Folder\Identity as Folder,
};
use Innmind\Filesystem\File;

final class AddFile
{
    private $identity;
    private $folder;
    private $file;

    public function __construct(
        Identity $identity,
        Folder $folder,
        File $file
    ) {
        $this->identity = $identity;
        $this->folder = $folder;
        $this->file = $file;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function folder(): Folder
    {
        return $this->folder;
    }

    public function file(): File
    {
        return $this->file;
    }
}
