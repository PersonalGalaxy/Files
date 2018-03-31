<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\{
    Command\TrashFile,
    Entity\File\Identity,
};
use PHPUnit\Framework\TestCase;

class TrashFileTest extends TestCase
{
    public function testInterface()
    {
        $command = new TrashFile(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $command->identity());
    }
}
