<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\{
    Event\FolderWasRestored,
    Entity\Folder\Identity,
};
use PHPUnit\Framework\TestCase;

class FolderWasRestoredTest extends TestCase
{
    public function testInterface()
    {
        $event = new FolderWasRestored(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $event->identity());
    }
}
