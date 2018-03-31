<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\{
    Command\RenameFolder,
    Entity\Folder\Identity,
    Entity\Folder\Name,
};
use PHPUnit\Framework\TestCase;

class RenameFolderTest extends TestCase
{
    public function testInterface()
    {
        $command = new RenameFolder(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo')
        );

        $this->assertSame($identity, $command->identity());
        $this->assertSame($name, $command->name());
    }
}
