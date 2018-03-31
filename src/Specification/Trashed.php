<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Specification;

use Innmind\Specification\{
    ComparatorInterface,
    CompositeInterface,
    SpecificationInterface,
    NotInterface,
};

final class Trashed implements ComparatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function property(): string
    {
        return 'trashed';
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
        return true;
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
