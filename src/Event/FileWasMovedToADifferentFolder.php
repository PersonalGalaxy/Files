<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\Entity\{
    File\Identity,
    Folder\Identity as Folder,
};

final class FileWasMovedToADifferentFolder
{
    private $identity;
    private $folder;

    public function __construct(
        Identity $identity,
        Folder $folder
    ) {
        $this->identity = $identity;
        $this->folder = $folder;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function folder(): Folder
    {
        return $this->folder;
    }
}
