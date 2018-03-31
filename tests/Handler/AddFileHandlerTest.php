<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\AddFileHandler,
    Command\AddFile,
    Repository\FileRepository,
    Repository\FolderRepository,
    Entity\File as Entity,
    Entity\File\Identity,
    Entity\Folder\Identity as Folder,
    Exception\FolderNotFound,
};
use Innmind\Filesystem\{
    Adapter,
    File,
    Name\Name,
    MediaType,
};
use PHPUnit\Framework\TestCase;

class AddFileHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new AddFileHandler(
            $files = $this->createMock(FileRepository::class),
            $folders = $this->createMock(FolderRepository::class),
            $filesystem = $this->createMock(Adapter::class)
        );
        $command = new AddFile(
            $this->createMock(Identity::class),
            $this->createMock(Folder::class),
            $file = $this->createMock(File::class)
        );
        $file
            ->expects($this->once())
            ->method('name')
            ->willReturn(new Name('foo'));
        $file
            ->expects($this->once())
            ->method('mediaType')
            ->willReturn($mediaType = $this->createMock(MediaType::class));
        $folders
            ->expects($this->once())
            ->method('has')
            ->with($command->folder())
            ->willReturn(true);
        $files
            ->expects($this->once())
            ->method('add')
            ->with($this->callback(static function(Entity $file) use ($command, $mediaType): bool {
                return $file->identity() === $command->identity() &&
                    $file->folder() === $command->folder() &&
                    (string) $file->name() === 'foo' &&
                    $file->mediaType() === $mediaType;
            }));
        $filesystem
            ->expects($this->once())
            ->method('add')
            ->with($command->file());

        $this->assertNull($handle($command));
    }

    public function testThrowWhenFolderNotFound()
    {
        $handle = new AddFileHandler(
            $files = $this->createMock(FileRepository::class),
            $folders = $this->createMock(FolderRepository::class),
            $filesystem = $this->createMock(Adapter::class)
        );
        $command = new AddFile(
            $this->createMock(Identity::class),
            $this->createMock(Folder::class),
            $this->createMock(File::class)
        );
        $folders
            ->expects($this->once())
            ->method('has')
            ->with($command->folder())
            ->willReturn(false);
        $files
            ->expects($this->never())
            ->method('add');
        $filesystem
            ->expects($this->never())
            ->method('add');

        try {
            $handle($command);
        } catch (FolderNotFound $e) {
            $this->assertSame($command->folder(), $e->identity());
        }
    }
}
