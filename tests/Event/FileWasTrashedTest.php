<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\{
    Event\FileWasTrashed,
    Entity\File\Identity,
};
use PHPUnit\Framework\TestCase;

class FileWasTrashedTest extends TestCase
{
    public function testInterface()
    {
        $event = new FileWasTrashed(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $event->identity());
    }
}
