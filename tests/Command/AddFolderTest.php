<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\{
    Command\AddFolder,
    Entity\Folder\Identity,
    Entity\Folder\Name,
};
use PHPUnit\Framework\TestCase;

class AddFolderTest extends TestCase
{
    public function testInterface()
    {
        $command = new AddFolder(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo'),
            $parent = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $command->identity());
        $this->assertSame($name, $command->name());
        $this->assertSame($parent, $command->parent());
    }
}
