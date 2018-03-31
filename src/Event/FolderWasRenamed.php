<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\Entity\{
    Folder\Identity,
    Folder\Name,
};

final class FolderWasRenamed
{
    private $identity;
    private $name;

    public function __construct(Identity $identity, Name $name)
    {
        $this->identity = $identity;
        $this->name = $name;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function name(): Name
    {
        return $this->name;
    }
}
