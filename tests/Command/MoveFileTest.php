<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\{
    Command\MoveFile,
    Entity\File\Identity,
    Entity\Folder\Identity as Folder,
};
use PHPUnit\Framework\TestCase;

class MoveFileTest extends TestCase
{
    public function testInterface()
    {
        $command = new MoveFile(
            $identity = $this->createMock(Identity::class),
            $folder = $this->createMock(Folder::class)
        );

        $this->assertSame($identity, $command->identity());
        $this->assertSame($folder, $command->folder());
    }
}
