<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\{
    Command\MoveFolder,
    Entity\Folder\Identity,
};
use PHPUnit\Framework\TestCase;

class MoveFolderTest extends TestCase
{
    public function testInterface()
    {
        $command = new MoveFolder(
            $identity = $this->createMock(Identity::class),
            $parent = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $command->identity());
        $this->assertSame($parent, $command->parent());
    }
}
