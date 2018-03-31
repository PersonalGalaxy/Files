<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Entity;

use PersonalGalaxy\Files\{
    Entity\File,
    Entity\File\Identity,
    Entity\File\Name,
    Entity\Folder\Identity as Folder,
    Event\FileWasAdded,
    Event\FileWasTrashed,
    Event\FileWasRestored,
    Event\FileWasRemoved,
    Event\FileWasRenamed,
    Event\FileWasMovedToADifferentFolder,
};
use Innmind\Filesystem\MediaType;
use Innmind\EventBus\ContainsRecordedEventsInterface;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testAdd()
    {
        $file = File::add(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo'),
            $folder = $this->createMock(Folder::class),
            $mediaType = $this->createMock(MediaType::class)
        );

        $this->assertInstanceOf(File::class, $file);
        $this->assertInstanceOf(ContainsRecordedEventsInterface::class, $file);
        $this->assertSame($identity, $file->identity());
        $this->assertSame($name, $file->name());
        $this->assertSame($folder, $file->folder());
        $this->assertSame($mediaType, $file->mediaType());
        $this->assertCount(1, $file->recordedEvents());
        $event = $file->recordedEvents()->first();
        $this->assertInstanceOf(FileWasAdded::class, $event);
        $this->assertSame($identity, $event->identity());
        $this->assertSame($name, $event->name());
        $this->assertSame($folder, $event->folder());
        $this->assertSame($mediaType, $event->mediaType());
    }

    public function testRename()
    {
        $file = File::add(
            $identity = $this->createMock(Identity::class),
            new Name('foo'),
            $this->createMock(Folder::class),
            $this->createMock(MediaType::class)
        );

        $this->assertSame($file, $file->rename($bar = new Name('bar')));
        $this->assertSame($bar, $file->name());
        $this->assertCount(2, $file->recordedEvents());
        $event = $file->recordedEvents()->last();
        $this->assertInstanceOf(FileWasRenamed::class, $event);
        $this->assertSame($identity, $event->identity());
        $this->assertSame($bar, $event->name());

        //verify nothing happens when renaming with the same name
        $this->assertSame($file, $file->rename(new Name('bar')));
        $this->assertSame($bar, $file->name());
        $this->assertCount(2, $file->recordedEvents());
    }

    public function testMoveTo()
    {
        $file = File::add(
            $identity = $this->createMock(Identity::class),
            new Name('foo'),
            $this->createMock(Folder::class),
            $this->createMock(MediaType::class)
        );

        $folder = $this->createMock(Folder::class);
        $folder
            ->expects($this->once())
            ->method('equals')
            ->with($file->folder())
            ->willReturn(false);
        $this->assertSame($file, $file->moveTo($folder));
        $this->assertSame($folder, $file->folder());
        $this->assertCount(2, $file->recordedEvents());
        $event = $file->recordedEvents()->last();
        $this->assertInstanceOf(FileWasMovedToADifferentFolder::class, $event);
        $this->assertSame($identity, $event->identity());
        $this->assertSame($folder, $event->folder());

        //verify nothing happens when renaming with the same name
        $other = $this->createMock(Folder::class);
        $other
            ->expects($this->once())
            ->method('equals')
            ->with($folder)
            ->willReturn(true);
        $this->assertSame($file, $file->moveTo($other));
        $this->assertSame($folder, $file->folder());
        $this->assertCount(2, $file->recordedEvents());
    }

    public function testTrash()
    {
        $file = File::add(
            $identity = $this->createMock(Identity::class),
            new Name('foo'),
            $this->createMock(Folder::class),
            $this->createMock(MediaType::class)
        );

        $this->assertFalse($file->trashed());
        $this->assertSame($file, $file->trash());
        $this->assertTrue($file->trashed());
        $this->assertCount(2, $file->recordedEvents());
        $event = $file->recordedEvents()->last();
        $this->assertInstanceOf(FileWasTrashed::class, $event);
        $this->assertSame($identity, $event->identity());

        //verify nothing happens when trashing an already trashed file
        $this->assertSame($file, $file->trash());
        $this->assertTrue($file->trashed());
        $this->assertCount(2, $file->recordedEvents());
    }

    public function testRestore()
    {
        $file = File::add(
            $identity = $this->createMock(Identity::class),
            new Name('foo'),
            $this->createMock(Folder::class),
            $this->createMock(MediaType::class)
        );

        //verify nothing happens when restoring an non  trashed file
        $this->assertSame($file, $file->restore());
        $this->assertFalse($file->trashed());
        $this->assertCount(1, $file->recordedEvents());

        $file->trash();
        $this->assertSame($file, $file->restore());
        $this->assertFalse($file->trashed());
        $this->assertCount(3, $file->recordedEvents());
        $event = $file->recordedEvents()->last();
        $this->assertInstanceOf(FileWasRestored::class, $event);
        $this->assertSame($identity, $event->identity());
    }

    public function testRemove()
    {
        $file = File::add(
            $identity = $this->createMock(Identity::class),
            new Name('foo'),
            $this->createMock(Folder::class),
            $this->createMock(MediaType::class)
        );

        $this->assertNull($file->remove());
        $this->assertCount(2, $file->recordedEvents());
        $event = $file->recordedEvents()->last();
        $this->assertInstanceOf(FileWasRemoved::class, $event);
        $this->assertSame($identity, $event->identity());
    }
}
