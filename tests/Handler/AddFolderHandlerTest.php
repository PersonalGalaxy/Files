<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\AddFolderHandler,
    Command\AddFolder,
    Repository\FolderRepository,
    Entity\Folder,
    Entity\Folder\Identity,
    Entity\Folder\Name,
    Exception\FolderNotFound,
};
use PHPUnit\Framework\TestCase;

class AddFolderHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new AddFolderHandler(
            $repository = $this->createMock(FolderRepository::class)
        );
        $command = new AddFolder(
            $this->createMock(Identity::class),
            new Name('foo'),
            $this->createMock(Identity::class)
        );
        $repository
            ->expects($this->once())
            ->method('has')
            ->with($command->parent())
            ->willReturn(true);
        $repository
            ->expects($this->once())
            ->method('add')
            ->with($this->callback(static function(Folder $folder) use ($command): bool {
                return $folder->identity() === $command->identity() &&
                    $folder->name() === $command->name() &&
                    $folder->parent() === $command->parent();
            }));

        $this->assertNull($handle($command));
    }

    public function testThrowWhenParentNotFound()
    {
        $handle = new AddFolderHandler(
            $repository = $this->createMock(FolderRepository::class)
        );
        $command = new AddFolder(
            $this->createMock(Identity::class),
            new Name('foo'),
            $this->createMock(Identity::class)
        );
        $repository
            ->expects($this->once())
            ->method('has')
            ->with($command->parent())
            ->willReturn(false);
        $repository
            ->expects($this->never())
            ->method('add');

        try {
            $handle($command);
        } catch (FolderNotFound $e) {
            $this->assertSame($command->parent(), $e->identity());
        }
    }
}
