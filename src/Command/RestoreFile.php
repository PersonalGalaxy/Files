<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\Entity\File\Identity;

final class RestoreFile
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
