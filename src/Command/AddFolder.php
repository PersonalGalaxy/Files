<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\Entity\Folder\{
    Identity,
    Name,
};

final class AddFolder
{
    private $identity;
    private $name;
    private $parent;

    public function __construct(
        Identity $identity,
        Name $name,
        Identity $parent
    ) {
        $this->identity = $identity;
        $this->name = $name;
        $this->parent = $parent;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function parent(): Identity
    {
        return $this->parent;
    }
}
