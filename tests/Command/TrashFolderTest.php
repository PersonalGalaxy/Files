<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\{
    Command\TrashFolder,
    Entity\Folder\Identity,
};
use PHPUnit\Framework\TestCase;

class TrashFolderTest extends TestCase
{
    public function testInterface()
    {
        $command = new TrashFolder(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $command->identity());
    }
}
