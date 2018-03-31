<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\RestoreFileHandler,
    Command\RestoreFile,
    Repository\FileRepository,
    Entity\File,
    Entity\File\Identity,
    Entity\File\Name,
    Entity\Folder\Identity as Folder,
};
use Innmind\Filesystem\MediaType;
use PHPUnit\Framework\TestCase;

class RestoreFileHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new RestoreFileHandler(
            $repository = $this->createMock(FileRepository::class)
        );
        $command = new RestoreFile(
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

        $file->trash();
        $this->assertNull($handle($command));
        $this->assertFalse($file->trashed());
    }
}
