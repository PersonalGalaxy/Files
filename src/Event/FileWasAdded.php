<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\Entity\{
    File\Identity,
    File\Name,
    Folder\Identity as Folder,
};
use Innmind\Filesystem\MediaType;

final class FileWasAdded
{
    private $identity;
    private $name;
    private $folder;
    private $mediaType;

    public function __construct(
        Identity $identity,
        Name $name,
        Folder $folder,
        MediaType $mediaType
    ) {
        $this->identity = $identity;
        $this->name = $name;
        $this->folder = $folder;
        $this->mediaType = $mediaType;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function folder(): Folder
    {
        return $this->folder;
    }

    public function mediaType(): MediaType
    {
        return $this->mediaType;
    }
}
