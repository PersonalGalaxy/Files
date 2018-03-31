<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Command;

use PersonalGalaxy\Files\{
    Command\AddFile,
    Entity\File\Identity,
    Entity\Folder\Identity as Folder,
};
use Innmind\Filesystem\File;
use PHPUnit\Framework\TestCase;

class AddFileTest extends TestCase
{
    public function testInterface()
    {
        $command = new AddFile(
            $identity = $this->createMock(Identity::class),
            $folder = $this->createMock(Folder::class),
            $file = $this->createMock(File::class)
        );

        $this->assertSame($identity, $command->identity());
        $this->assertSame($folder, $command->folder());
        $this->assertSame($file, $command->file());
    }
}
