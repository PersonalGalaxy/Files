<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\RestoreFolderHandler,
    Command\RestoreFolder,
    Repository\FolderRepository,
    Entity\Folder,
    Entity\Folder\Identity,
    Entity\Folder\Name,
};
use PHPUnit\Framework\TestCase;

class RestoreFolderHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new RestoreFolderHandler(
            $repository = $this->createMock(FolderRepository::class)
        );
        $command = new RestoreFolder(
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

        $folder->trash();
        $this->assertNull($handle($command));
        $this->assertFalse($folder->trashed());
    }
}
