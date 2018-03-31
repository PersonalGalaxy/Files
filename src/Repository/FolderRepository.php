<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Repository;

use PersonalGalaxy\Files\Entity\{
    Folder,
    Folder\Identity,
};
use Innmind\Immutable\SetInterface;
use Innmind\Specification\SpecificationInterface;

interface FolderRepository
{
    /**
     * @throws FolderNotFound
     */
    public function get(Identity $identity): Folder;
    public function add(Folder $folder): self;
    public function remove(Identity $identity): self;
    public function has(Identity $identity): bool;
    public function count(): int;
    /**
     * @return SetInterface<Folder>
     */
    public function all(): SetInterface;
    /**
     * @return SetInterface<Folder>
     */
    public function matching(SpecificationInterface $specification): SetInterface;
}
