<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Specification;

use PersonalGalaxy\Files\Specification\Trashed;
use Innmind\Specification\ComparatorInterface;
use PHPUnit\Framework\TestCase;

class TrashedTest extends TestCase
{
    public function testInterface()
    {
        $spec = new Trashed;

        $this->assertInstanceOf(ComparatorInterface::class, $spec);
        $this->assertSame('trashed', $spec->property());
        $this->assertSame('=', $spec->sign());
        $this->assertSame(true, $spec->value());
    }
}
