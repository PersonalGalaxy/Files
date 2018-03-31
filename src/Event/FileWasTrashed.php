<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\Entity\File\Identity;

final class FileWasTrashed
{
    private $identity;

    public function __construct(Identity $identity)
    {
        $this->identity = $identity;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }
}
