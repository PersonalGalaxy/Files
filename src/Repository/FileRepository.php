<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Repository;

use PersonalGalaxy\Files\Entity\{
    File,
    File\Identity,
};
use Innmind\Immutable\SetInterface;
use Innmind\Specification\SpecificationInterface;

interface FileRepository
{
    /**
     * @throws FileNotFound
     */
    public function get(Identity $identity): File;
    public function add(File $file): self;
    public function remove(Identity $identity): self;
    public function has(Identity $identity): bool;
    public function count(): int;
    /**
     * @return SetInterface<File>
     */
    public function all(): SetInterface;
    /**
     * @return SetInterface<File>
     */
    public function matching(SpecificationInterface $specification): SetInterface;
}
