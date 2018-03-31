<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Event;

use PersonalGalaxy\Files\{
    Event\FolderWasMovedToADifferentParent,
    Entity\Folder\Identity,
};
use PHPUnit\Framework\TestCase;

class FolderWasMovedToADifferentParentTest extends TestCase
{
    public function testInterface()
    {
        $event = new FolderWasMovedToADifferentParent(
            $identity = $this->createMock(Identity::class),
            $parent = $this->createMock(Identity::class)
        );

        $this->assertSame($identity, $event->identity());
        $this->assertSame($parent, $event->parent());
    }
}
