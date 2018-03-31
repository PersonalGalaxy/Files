<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\{
    Command\RenameFile,
    Entity\File\Identity,
    Entity\File\Name,
};
use PHPUnit\Framework\TestCase;

class RenameFileTest extends TestCase
{
    public function testInterface()
    {
        $command = new RenameFile(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo')
        );

        $this->assertSame($identity, $command->identity());
        $this->assertSame($name, $command->name());
    }
}
