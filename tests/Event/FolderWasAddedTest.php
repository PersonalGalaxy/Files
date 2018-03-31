<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\{
    Event\FolderWasAdded,
    Entity\Folder\Identity,
    Entity\Folder\Name,
};
use PHPUnit\Framework\TestCase;

class FolderWasAddedTest extends TestCase
{
    public function testInterface()
    {
        $event = new FolderWasAdded(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo'),
            $parent = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($name, $event->name());
        $this->assertSame($parent, $event->parent());
    }
}
