<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Exception;

use PersonalGalaxy\Files\Entity\Folder\Identity;

final class FolderNotFound extends LogicException
{
    private $identity;

    public function __construct(Identity $identity)
    {
        $this->identity = $identity;
        parent::__construct((string) $identity);
    }

    public function identity(): Identity
    {
        return $this->identity;
    }
}
