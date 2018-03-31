<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\{
    Event\FileWasRestored,
    Entity\File\Identity,
};
use PHPUnit\Framework\TestCase;

class FileWasRestoredTest extends TestCase
{
    public function testInterface()
    {
        $event = new FileWasRestored(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $event->identity());
    }
}
