<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\{
    Command\RestoreFile,
    Entity\File\Identity,
};
use PHPUnit\Framework\TestCase;

class RestoreFileTest extends TestCase
{
    public function testInterface()
    {
        $command = new RestoreFile(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $command->identity());
    }
}
