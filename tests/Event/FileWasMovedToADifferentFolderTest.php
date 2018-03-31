<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\{
    Event\FileWasMovedToADifferentFolder,
    Entity\File\Identity,
    Entity\Folder\Identity as Folder,
};
use PHPUnit\Framework\TestCase;

class FileWasMovedToADifferentFolderTest extends TestCase
{
    public function testInterface()
    {
        $event = new FileWasMovedToADifferentFolder(
            $identity = $this->createMock(Identity::class),
            $folder = $this->createMock(Folder::class)
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($folder, $event->folder());
    }
}
