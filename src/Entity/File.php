<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Entity;

use PersonalGalaxy\Files\{
    Entity\File\Identity,
    Entity\File\Name,
    Entity\Folder\Identity as Folder,
    Event\FileWasAdded,
    Event\FileWasTrashed,
    Event\FileWasRestored,
    Event\FileWasRemoved,
    Event\FileWasRenamed,
};
use Innmind\EventBus\{
    ContainsRecordedEventsInterface,
    EventRecorder,
};
use Innmind\Filesystem\MediaType;

final class File implements ContainsRecordedEventsInterface
{
    use EventRecorder;

    private $identity;
    private $name;
    private $folder;
    private $mediaType;
    private $trashed = false;

    private function __construct(
        Identity $identity,
        Name $name,
        Folder $folder,
        MediaType $mediaType
    ) {
        $this->identity = $identity;
        $this->name = $name;
        $this->folder = $folder;
        $this->mediaType = $mediaType;
    }

    public static function add(
        Identity $identity,
        Name $name,
        Folder $folder,
        MediaType $mediaType
    ): self {
        $self = new self($identity, $name, $folder, $mediaType);
        $self->record(new FileWasAdded($identity, $name, $folder, $mediaType));

        return $self;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function folder(): Folder
    {
        return $this->folder;
    }

    public function mediaType(): MediaType
    {
        return $this->mediaType;
    }

    public function trashed(): bool
    {
        return $this->trashed;
    }

    public function rename(Name $name): self
    {
        if ($name->equals($this->name)) {
            return $this;
        }

        $this->name = $name;
        $this->record(new FileWasRenamed($this->identity, $name));

        return $this;
    }

    public function trash(): self
    {
        if ($this->trashed) {
            return $this;
        }

        $this->trashed = true;
        $this->record(new FileWasTrashed($this->identity));

        return $this;
    }

    public function restore(): self
    {
        if (!$this->trashed) {
            return $this;
        }

        $this->trashed = false;
        $this->record(new FileWasRestored($this->identity));

        return $this;
    }

    /**
     * Last method that can be called, here only to record the event
     */
    public function remove(): void
    {
        $this->record(new FileWasRemoved($this->identity));
    }
}
