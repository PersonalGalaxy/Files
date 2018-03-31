<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Specification;

use PersonalGalaxy\Files\Entity\Folder\Identity;
use Innmind\Specification\{
    ComparatorInterface,
    CompositeInterface,
    SpecificationInterface,
    NotInterface,
};

final class ParentFolder implements ComparatorInterface
{
    private $value;

    public function __construct(Identity $identity)
    {
        $this->value = (string) $identity;
    }

    /**
     * {@inheritdoc}
     */
    public function property(): string
    {
        return 'parent';
    }

    /**
     * {@inheritdoc}
     */
    public function sign(): string
    {
        return '=';
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function and(SpecificationInterface $specification): CompositeInterface
    {
        //not implemented
    }

    /**
     * {@inheritdoc}
     */
    public function or(SpecificationInterface $specification): CompositeInterface
    {
        //not implemented
    }

    /**
     * {@inheritdoc}
     */
    public function not(): NotInterface
    {
        //not implemented
    }
}
