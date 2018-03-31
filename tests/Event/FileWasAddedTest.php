<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\{
    Event\FileWasAdded,
    Entity\File\Identity,
    Entity\File\Name,
    Entity\Folder\Identity as Folder,
};
use Innmind\Filesystem\MediaType;
use PHPUnit\Framework\TestCase;

class FileWasAddedTest extends TestCase
{
    public function testInterface()
    {
        $event = new FileWasAdded(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo'),
            $folder = $this->createMock(Folder::class),
            $mediaType = $this->createMock(MediaType::class)
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($name, $event->name());
        $this->assertSame($folder, $event->folder());
        $this->assertSame($mediaType, $event->mediaType());
    }
}
