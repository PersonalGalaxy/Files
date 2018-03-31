<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\MoveFileHandler,
    Command\MoveFile,
    Repository\FileRepository,
    Repository\FolderRepository,
    Entity\File,
    Entity\File\Identity,
    Entity\File\Name,
    Entity\Folder\Identity as Folder,
    Exception\FolderNotFound,
};
use Innmind\Filesystem\MediaType;
use PHPUnit\Framework\TestCase;

class MoveFileHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new MoveFileHandler(
            $files = $this->createMock(FileRepository::class),
            $folders = $this->createMock(FolderRepository::class)
        );
        $command = new MoveFile(
            $this->createMock(Identity::class),
            $this->createMock(Folder::class)
        );
        $folders
            ->expects($this->once())
            ->method('has')
            ->with($command->folder())
            ->willReturn(true);
        $files
            ->expects($this->once())
            ->method('get')
            ->with($command->identity())
            ->willReturn($file = File::add(
                $command->identity(),
                new Name('foo'),
                $this->createMock(Folder::class),
                $this->createMock(MediaType::class)
            ));

        $this->assertNull($handle($command));
        $this->assertSame($command->folder(), $file->folder());
    }

    public function testThrowWhenFolderNotFound()
    {
        $handle = new MoveFileHandler(
            $files = $this->createMock(FileRepository::class),
            $folders = $this->createMock(FolderRepository::class)
        );
        $command = new MoveFile(
            $this->createMock(Identity::class),
            $this->createMock(Folder::class)
        );
        $folders
            ->expects($this->once())
            ->method('has')
            ->with($command->folder())
            ->willReturn(false);
        $files
            ->expects($this->never())
            ->method('get');

        try {
            $handle($command);
        } catch (FolderNotFound $e) {
            $this->assertSame($command->folder(), $e->identity());
        }
    }
}
