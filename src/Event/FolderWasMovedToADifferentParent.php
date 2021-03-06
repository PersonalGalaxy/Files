<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\Entity\Folder\Identity;

final class FolderWasMovedToADifferentParent
{
    private $identity;
    private $parent;

    public function __construct(
        Identity $identity,
        Identity $parent
    ) {
        $this->identity = $identity;
        $this->parent = $parent;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function parent(): Identity
    {
        return $this->parent;
    }
}
