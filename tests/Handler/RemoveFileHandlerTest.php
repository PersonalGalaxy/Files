<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\RemoveFileHandler,
    Command\RemoveFile,
    Repository\FileRepository,
    Entity\File,
    Entity\File\Identity,
    Entity\File\Name,
    Entity\Folder\Identity as Folder,
};
use Innmind\Filesystem\{
    Adapter,
    MediaType,
};
use PHPUnit\Framework\TestCase;

class RemoveFileHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new RemoveFileHandler(
            $repository = $this->createMock(FileRepository::class),
            $filesystem = $this->createMock(Adapter::class)
        );
        $command = new RemoveFile(
            $this->createMock(Identity::class)
        );
        $repository
            ->expects($this->once())
            ->method('get')
            ->with($command->identity())
            ->willReturn($file = File::add(
                $command->identity(),
                new Name('foo'),
                $this->createMock(Folder::class),
                $this->createMock(MediaType::class)
            ));
        $filesystem
            ->expects($this->once())
            ->method('remove')
            ->with('foo');

        $file->trash();
        $this->assertNull($handle($command));
    }
}
