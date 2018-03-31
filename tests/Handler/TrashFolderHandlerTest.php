<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\TrashFolderHandler,
    Command\TrashFolder,
    Repository\FolderRepository,
    Entity\Folder,
    Entity\Folder\Identity,
    Entity\Folder\Name,
};
use PHPUnit\Framework\TestCase;

class TrashFolderHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new TrashFolderHandler(
            $repository = $this->createMock(FolderRepository::class)
        );
        $command = new TrashFolder(
            $this->createMock(Identity::class)
        );
        $repository
            ->expects($this->once())
            ->method('get')
            ->with($command->identity())
            ->willReturn($folder = Folder::add(
                $command->identity(),
                new Name('foo'),
                $this->createMock(Identity::class)
            ));

        $this->assertNull($handle($command));
        $this->assertTrue($folder->trashed());
    }
}
