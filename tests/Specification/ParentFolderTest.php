<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Specification;

use PersonalGalaxy\Files\{
    Specification\ParentFolder,
    Entity\Folder\Identity,
};
use Innmind\Specification\ComparatorInterface;
use PHPUnit\Framework\TestCase;
use Eris\{
    TestTrait,
    Generator,
};

class ParentFolderTest extends TestCase
{
    use TestTrait;

    public function testInterface()
    {
        $this
            ->forAll(Generator\string())
            ->then(function(string $string): void {
                $identity = $this->createMock(Identity::class);
                $identity
                    ->expects($this->once())
                    ->method('__toString')
                    ->willReturn($string);
                $spec = new ParentFolder($identity);

                $this->assertInstanceOf(ComparatorInterface::class, $spec);
                $this->assertSame('parent', $spec->property());
                $this->assertSame('=', $spec->sign());
                $this->assertSame($string, $spec->value());
            });
    }
}
