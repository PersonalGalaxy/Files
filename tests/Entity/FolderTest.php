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
    Event\FolderWasMovedToADifferentParent,
    Exception\LogicException,
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

    public function testMoveTo()
    {
        $folder = Folder::add(
            $identity = $this->createMock(Identity::class),
            new Name('foo'),
            $this->createMock(Identity::class)
        );

        $parent = $this->createMock(Identity::class);
        $parent
            ->expects($this->once())
            ->method('equals')
            ->with($folder->parent())
            ->willReturn(false);
        $this->assertSame($folder, $folder->moveTo($parent));
        $this->assertSame($parent, $folder->parent());
        $this->assertCount(2, $folder->recordedEvents());
        $event = $folder->recordedEvents()->last();
        $this->assertInstanceOf(FolderWasMovedToADifferentParent::class, $event);
        $this->assertSame($identity, $event->identity());
        $this->assertSame($parent, $event->parent());

        //verify nothing happens when renaming with the same name
        $other = $this->createMock(Identity::class);
        $other
            ->expects($this->once())
            ->method('equals')
            ->with($parent)
            ->willReturn(true);
        $this->assertSame($folder, $folder->moveTo($other));
        $this->assertSame($parent, $folder->parent());
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

        try {
            $folder->remove();

            $this->fail('it should throw');
        } catch (LogicException $e) {
            //pass
        }

        $folder->trash();
        $this->assertNull($folder->remove());
        $this->assertCount(3, $folder->recordedEvents());
        $event = $folder->recordedEvents()->last();
        $this->assertInstanceOf(FolderWasRemoved::class, $event);
        $this->assertSame($identity, $event->identity());
    }
}
