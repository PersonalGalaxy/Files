<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Entity;

use PersonalGalaxy\Files\{
    Entity\Folder,
    Entity\Folder\Identity,
    Entity\Folder\Name,
    Event\FolderWasAdded,
    Event\FolderWasRenamed,
    Event\FolderWasTrashed,
    Event\FolderWasRestored,
    Event\FolderWasRemoved,
};
use Innmind\EventBus\ContainsRecordedEventsInterface;
use PHPUnit\Framework\TestCase;

class FolderTest extends TestCase
{
    public function testAdd()
    {
        $folder = Folder::add(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo'),
            $parent = $this->createMock(Identity::class)
        );

        $this->assertInstanceOf(Folder::class, $folder);
        $this->assertInstanceOf(ContainsRecordedEventsInterface::class, $folder);
        $this->assertSame($identity, $folder->identity());
        $this->assertSame($name, $folder->name());
        $this->assertSame($parent, $folder->parent());
        $this->assertCount(1, $folder->recordedEvents());
        $event = $folder->recordedEvents()->first();
        $this->assertInstanceOf(FolderWasAdded::class, $event);
        $this->assertSame($identity, $event->identity());
        $this->assertSame($name, $event->name());
        $this->assertSame($parent, $event->parent());
    }

    public function testRename()
    {
        $folder = Folder::add(
            $identity = $this->createMock(Identity::class),
            new Name('foo'),
            $this->createMock(Identity::class)
        );

        $this->assertSame($folder, $folder->rename($bar = new Name('bar')));
        $this->assertSame($bar, $folder->name());
        $this->assertCount(2, $folder->recordedEvents());
        $event = $folder->recordedEvents()->last();
        $this->assertInstanceOf(FolderWasRenamed::class, $event);
        $this->assertSame($identity, $event->identity());
        $this->assertSame($bar, $event->name());

        //verify nothing happens when renaming with the same name
        $this->assertSame($folder, $folder->rename(new Name('bar')));
        $this->assertSame($bar, $folder->name());
        $this->assertCount(2, $folder->recordedEvents());
    }

    public function tesTrash()
    {
        $folder = Folder::add(
            $identity = $this->createMock(Identity::class),
            new Name('foo'),
            $this->createMock(Identity::class)
        );

        $this->assertFalse($folder->trashed());
        $this->assertSame($folder, $folder->trash());
        $this->assertTrue($folder->trashed());
        $this->assertCount(2, $folder->recordedEvents());
        $event = $folder->recordedEvents()->last();
        $this->assertInstanceOf(FolderWasTrashed::class, $event);
        $this->assertSame($identity, $event->identity());

        //verify nothing happens when trashing an already trashed folder
        $this->assertSame($folder, $folder->trash());
        $this->assertTrue($folder->trashed());
        $this->assertCount(2, $folder->recordedEvents());
    }

    public function testRestore()
    {
        $folder = Folder::add(
            $identity = $this->createMock(Identity::class),
            new Name('foo'),
            $this->createMock(Identity::class)
        );

        //verify nothing happens when restoring a non trashed folder
        $this->assertSame($folder, $folder->restore());
        $this->assertFalse($folder->trashed());
        $this->assertCount(1, $folder->recordedEvents());

        $folder->trash();
        $this->assertSame($folder, $folder->restore());
        $this->assertFalse($folder->trashed());
        $this->assertCount(3, $folder->recordedEvents());
        $event = $folder->recordedEvents()->last();
        $this->assertInstanceOf(FolderWasRestored::class, $event);
        $this->assertSame($identity, $event->identity());
    }

    public function testRemove()
    {
        $folder = Folder::add(
            $identity = $this->createMock(Identity::class),
            new Name('foo'),
            $this->createMock(Identity::class)
        );

        $this->assertNull($folder->remove());
        $this->assertCount(2, $folder->recordedEvents());
        $event = $folder->recordedEvents()->last();
        $this->assertInstanceOf(FolderWasRemoved::class, $event);
        $this->assertSame($identity, $event->identity());
    }
}
