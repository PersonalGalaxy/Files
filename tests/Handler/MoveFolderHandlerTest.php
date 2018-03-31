<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\MoveFolderHandler,
    Command\MoveFolder,
    Repository\FolderRepository,
    Entity\Folder,
    Entity\Folder\Identity,
    Entity\Folder\Name,
    Exception\FolderNotFound,
};
use PHPUnit\Framework\TestCase;

class MoveFolderHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new MoveFolderHandler(
            $repository = $this->createMock(FolderRepository::class)
        );
        $command = new MoveFolder(
            $this->createMock(Identity::class),
            $this->createMock(Identity::class)
        );
        $repository
            ->expects($this->once())
            ->method('has')
            ->with($command->parent())
            ->willReturn(true);
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
        $this->assertSame($command->parent(), $folder->parent());
    }

    public function testThrowWhenParentNotFound()
    {
        $handle = new MoveFolderHandler(
            $repository = $this->createMock(FolderRepository::class)
        );
        $command = new MoveFolder(
            $this->createMock(Identity::class),
            $this->createMock(Identity::class)
        );
        $repository
            ->expects($this->once())
            ->method('has')
            ->with($command->parent())
            ->willReturn(false);
        $repository
            ->expects($this->never())
            ->method('get');

        try {
            $handle($command);
        } catch (FolderNotFound $e) {
            $this->assertSame($command->parent(), $e->identity());
        }
    }
}
