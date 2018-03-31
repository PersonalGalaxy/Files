<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\{
    Command\RestoreFolder,
    Entity\Folder\Identity,
};
use PHPUnit\Framework\TestCase;

class RestoreFolderTest extends TestCase
{
    public function testInterface()
    {
        $command = new RestoreFolder(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $command->identity());
    }
}
