<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Entity\Folder;

interface Identity
{
    public function equals(self $identity): bool;
    public function __toString(): string;
}
