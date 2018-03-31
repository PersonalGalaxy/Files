<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\RenameFileHandler,
    Command\RenameFile,
    Repository\FileRepository,
    Entity\File,
    Entity\File\Identity,
    Entity\File\Name,
    Entity\Folder\Identity as Folder,
};
use Innmind\Filesystem\MediaType;
use PHPUnit\Framework\TestCase;

class RenameFileHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new RenameFileHandler(
            $repository = $this->createMock(FileRepository::class)
        );
        $command = new RenameFile(
            $this->createMock(Identity::class),
            new Name('bar')
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

        $this->assertNull($handle($command));
        $this->assertSame($command->name(), $file->name());
    }
}
