<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\{
    Event\FolderWasRenamed,
    Entity\Folder\Identity,
    Entity\Folder\Name,
};
use PHPUnit\Framework\TestCase;

class FolderWasRenamedTest extends TestCase
{
    public function testInterface()
    {
        $event = new FolderWasRenamed(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo')
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($name, $event->name());
    }
}
