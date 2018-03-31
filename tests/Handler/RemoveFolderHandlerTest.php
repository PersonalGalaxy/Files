<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\RemoveFolderHandler,
    Handler\RemoveFileHandler,
    Command\RemoveFolder,
    Repository\FileRepository,
    Repository\FolderRepository,
    Entity\File,
    Entity\Folder,
    Entity\Folder\Identity,
    Entity\Folder\Name,
    Specification\ParentFolder,
    Specification\FileFolder,
    Event\FolderWasRemoved,
};
use Innmind\Filesystem\{
    Adapter,
    MediaType,
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class RemoveFolderHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new RemoveFolderHandler(
            $files = $this->createMock(FileRepository::class),
            $folders = $this->createMock(FolderRepository::class),
            new RemoveFileHandler(
                $files,
                $filesystem = $this->createMock(Adapter::class)
            )
        );
        $command = new RemoveFolder($this->createMock(Identity::class));
        $folders
            ->expects($this->at(0))
            ->method('get')
            ->with($command->identity())
            ->willReturn($folder = Folder::add(
                $command->identity(),
                new Name('watev'),
                $this->createMock(Identity::class)
            ));
        $folders
            ->expects($this->at(1))
            ->method('matching')
            ->with(new ParentFolder($command->identity()))
            ->willReturn(Set::of(
                Folder::class,
                $parent = Folder::add(
                    $this->createMock(Identity::class),
                    new Name('foo'),
                    $this->createMock(Identity::class)
                )
            ));
        $folders
            ->expects($this->at(2))
            ->method('get')
            ->with($parent->identity())
            ->willReturn($parent);
        $folders
            ->expects($this->at(3))
            ->method('matching')
            ->with(new ParentFolder($parent->identity()))
            ->willReturn(Set::of(Folder::class));
        $files
            ->expects($this->at(0))
            ->method('matching')
            ->with(new FileFolder($parent->identity()))
            ->willReturn(Set::of(File::class));
        $folders
            ->expects($this->at(4))
            ->method('remove')
            ->with($parent->identity());
        $files
            ->expects($this->at(1))
            ->method('matching')
            ->with(new FileFolder($command->identity()))
            ->willReturn(Set::of(
                File::class,
                $file = File::add(
                    $this->createMock(File\Identity::class),
                    new File\Name('foo'),
                    $command->identity(),
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
        $filesystem
            ->expects($this->once())
            ->method('remove')
            ->with('foo');
        $folders
            ->expects($this->at(5))
            ->method('remove')
            ->with($folder->identity());

        $folder->trash();
        $this->assertNull($handle($command));
        $this->assertInstanceOf(
            FolderWasRemoved::class,
            $parent->recordedEvents()->last()
        );
        $this->assertInstanceOf(
            FolderWasRemoved::class,
            $folder->recordedEvents()->last()
        );
    }
}
