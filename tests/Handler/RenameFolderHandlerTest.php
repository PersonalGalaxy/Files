<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\RenameFolderHandler,
    Command\RenameFolder,
    Repository\FolderRepository,
    Entity\Folder,
    Entity\Folder\Identity,
    Entity\Folder\Name,
};
use PHPUnit\Framework\TestCase;

class RenameFolderHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new RenameFolderHandler(
            $repository = $this->createMock(FolderRepository::class)
        );
        $command = new RenameFolder(
            $this->createMock(Identity::class),
            new Name('bar')
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
        $this->assertSame($command->name(), $folder->name());
    }
}
