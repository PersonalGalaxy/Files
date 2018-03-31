<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\{
    Command\RemoveFile,
    Entity\File\Identity,
};
use PHPUnit\Framework\TestCase;

class RemoveFileTest extends TestCase
{
    public function testInterface()
    {
        $command = new RemoveFile(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $command->identity());
    }
}
