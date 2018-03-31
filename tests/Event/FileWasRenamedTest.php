<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\{
    Event\FileWasRenamed,
    Entity\File\Identity,
    Entity\File\Name,
};
use PHPUnit\Framework\TestCase;

class FileWasRenamedTest extends TestCase
{
    public function testInterface()
    {
        $event = new FileWasRenamed(
            $identity = $this->createMock(Identity::class),
            $name = new Name('foo')
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($name, $event->name());
    }
}
