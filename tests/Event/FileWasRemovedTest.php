<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\{
    Event\FileWasRemoved,
    Entity\File\Identity,
};
use PHPUnit\Framework\TestCase;

class FileWasRemovedTest extends TestCase
{
    public function testInterface()
    {
        $event = new FileWasRemoved(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $event->identity());
    }
}
