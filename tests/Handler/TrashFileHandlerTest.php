<?php
declare(strict_types = 1);

namespace Tests\PersonalGalaxy\Files\Handler;

use PersonalGalaxy\Files\{
    Handler\TrashFileHandler,
    Command\TrashFile,
    Repository\FileRepository,
    Entity\File,
    Entity\File\Identity,
    Entity\File\Name,
    Entity\Folder\Identity as Folder,
};
use Innmind\Filesystem\MediaType;
use PHPUnit\Framework\TestCase;

class TrashFileHandlerTest extends TestCase
{
    public function testInvokation()
    {
        $handle = new TrashFileHandler(
            $repository = $this->createMock(FileRepository::class)
        );
        $command = new TrashFile(
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

        $this->assertNull($handle($command));
        $this->assertTrue($file->trashed());
    }
}
