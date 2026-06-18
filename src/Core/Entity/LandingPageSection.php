<?php

namespace App\Core\Entity;

use App\Core\Repository\LandingPageSectionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LandingPageSectionRepository::class)]
#[ORM\Table(name: 'landing_page_section')]
class LandingPageSection extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private string $sectionType;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column]
    private int $sortOrder = 0;

    #[ORM\Column]
    private bool $isEnabled = true;

    #[ORM\Column(type: Types::JSON)]
    private array $content = [];

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSectionType(): string
    {
        return $this->sectionType;
    }

    public function setSectionType(string $sectionType): static
    {
        $this->sectionType = $sectionType;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): static
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): static
    {
        $this->isEnabled = $isEnabled;
        return $this;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function setContent(array $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getContentValue(string $key, mixed $default = null): mixed
    {
        return $this->content[$key] ?? $default;
    }

    public function setContentValue(string $key, mixed $value): static
    {
        $this->content[$key] = $value;
        return $this;
    }
}
