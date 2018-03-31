<?php
declare(strict_types = 1);

namespace PersonalGalaxy\Files\Entity;

use PersonalGalaxy\Files\{
    Entity\Folder\Identity,
    Entity\Folder\Name,
    Event\FolderWasAdded,
    Event\FolderWasTrashed,
    Event\FolderWasRestored,
    Event\FolderWasRemoved,
    Event\FolderWasRenamed,
};
use Innmind\EventBus\{
    ContainsRecordedEventsInterface,
    EventRecorder,
};

final class Folder implements ContainsRecordedEventsInterface
{
    use EventRecorder;

    private $identity;
    private $name;
    private $parent;
    private $trashed = false;

    private function __construct(
        Identity $identity,
        Name $name,
        Identity $parent
    ) {
        $this->identity = $identity;
        $this->name = $name;
        $this->parent = $parent;
    }

    public static function add(
        Identity $identity,
        Name $name,
        Identity $parent
    ): self {
        $self = new self($identity, $name, $parent);
        $self->record(new FolderWasAdded($identity, $name, $parent));

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

    public function parent(): Identity
    {
        return $this->parent;
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
        $this->record(new FolderWasRenamed($this->identity, $name));

        return $this;
    }

    public function trash(): self
    {
        if ($this->trashed) {
            return $this;
        }

        $this->trashed = true;
        $this->record(new FolderWasTrashed($this->identity));

        return $this;
    }

    public function restore(): self
    {
        if (!$this->trashed) {
            return $this;
        }

        $this->trashed = false;
        $this->record(new FolderWasRestored($this->identity));

        return $this;
    }

    /**
     * Last method that can be called, here only to record the event
     */
    public function remove(): void
    {
        $this->record(new FolderWasRemoved($this->identity));
    }
}
