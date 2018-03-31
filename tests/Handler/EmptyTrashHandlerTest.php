<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\EmptyTrashHandler,
    Handler\RemoveFileHandler,
    Handler\RemoveFolderHandler,
    Command\EmptyTrash,
    Repository\FileRepository,
    Repository\FolderRepository,
    Entity\Folder,
    Entity\Folder\Identity,
    Entity\Folder\Name,
    Entity\File,
    Specification\Trashed,
    Specification\ParentFolder,
    Specification\FileFolder,
};
use Innmind\Filesystem\{
    Adapter,
    MediaType,
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class EmptyTrashHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new EmptyTrashHandler(
            $files = $this->createMock(FileRepository::class),
            $folders = $this->createMock(FolderRepository::class),
            $removeFile = new RemoveFileHandler(
                $files,
                $this->createMock(Adapter::class)
            ),
            new RemoveFolderHandler(
                $files,
                $folders,
                $removeFile
            )
        );
        $folders
            ->expects($this->at(0))
            ->method('matching')
            ->with(new Trashed)
            ->willReturn(Set::of(
                Folder::class,
                $folder = Folder::add(
                    $this->createMock(Identity::class),
                    new Name('foo'),
                    $this->createMock(Identity::class)
                )
            ));
        $folders
            ->expects($this->at(1))
            ->method('get')
            ->with($folder->identity())
            ->willReturn($folder);
        $folders
            ->expects($this->at(2))
            ->method('matching')
            ->with(new ParentFolder($folder->identity()))
            ->willReturn(Set::of(Folder::class));
        $files
            ->expects($this->at(0))
            ->method('matching')
            ->with(new FileFolder($folder->identity()))
            ->willReturn(Set::of(File::class));
        $folders
            ->expects($this->at(3))
            ->method('remove')
            ->with($folder->identity());
        $files
            ->expects($this->at(1))
            ->method('matching')
            ->with(new Trashed)
            ->willReturn(Set::of(
                File::class,
                $file = File::add(
                    $this->createMock(File\Identity::class),
                    new File\Name('foo'),
                    $this->createMock(Identity::class),
                    $this->createMock(MediaType::class)
                )
            ));
        $files
            ->expects($this->at(2))
            ->method('get')
            ->with($file->identity())
            ->willReturn($file);
        $files
            ->expects($this->at(3))
            ->method('remove')
            ->with($file->identity());

        $folder->trash();
        $file->trash();
        $this->assertNull($handle(new EmptyTrash));
    }
}
