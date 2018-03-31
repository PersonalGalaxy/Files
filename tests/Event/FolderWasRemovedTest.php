<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\{
    Event\FolderWasRemoved,
    Entity\Folder\Identity,
};
use PHPUnit\Framework\TestCase;

class FolderWasRemovedTest extends TestCase
{
    public function testInterface()
    {
        $event = new FolderWasRemoved(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $event->identity());
    }
}
