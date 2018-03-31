<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\{
    Event\FolderWasTrashed,
    Entity\Folder\Identity,
};
use PHPUnit\Framework\TestCase;

class FolderWasTrashedTest extends TestCase
{
    public function testInterface()
    {
        $event = new FolderWasTrashed(
            $identity = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $event->identity());
    }
}
