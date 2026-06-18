<?php

namespace App\Core\Service\LandingPage;

use App\Core\Entity\LandingPageSection;
use App\Core\Repository\LandingPageSectionRepository;
use Doctrine\ORM\EntityManagerInterface;

class LandingPageService
{
    public function __construct(
        private readonly LandingPageSectionRepository $repository,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function getAllSections(): array
    {
        return $this->repository->findAllSorted();
    }

    public function getEnabledSections(): array
    {
        return $this->repository->findAllEnabled();
    }

    public function getSection(string $sectionType): ?LandingPageSection
    {
        return $this->repository->findByType($sectionType);
    }

    public function getSectionContent(string $sectionType, array $default = []): array
    {
        $section = $this->getSection($sectionType);
        if ($section === null || !$section->isEnabled()) {
            return $default;
        }
        return $section->getContent();
    }

    public function saveSection(string $sectionType, array $content, ?string $title = null, ?bool $isEnabled = null, ?int $sortOrder = null): LandingPageSection
    {
        $section = $this->getSection($sectionType);

        if ($section === null) {
            $section = new LandingPageSection();
            $section->setSectionType($sectionType);
            $section->setTitle($title ?? ucfirst($sectionType));
            $section->setSortOrder($sortOrder ?? $this->repository->getMaxSortOrder() + 1);
            $this->entityManager->persist($section);
        }

        $section->setContent($content);
        $section->preUpdate();

        if ($title !== null) {
            $section->setTitle($title);
        }
        if ($isEnabled !== null) {
            $section->setIsEnabled($isEnabled);
        }
        if ($sortOrder !== null) {
            $section->setSortOrder($sortOrder);
        }

        $this->entityManager->flush();

        return $section;
    }

    public function toggleSection(string $sectionType): bool
    {
        $section = $this->getSection($sectionType);
        if ($section === null) {
            return false;
        }

        $section->setIsEnabled(!$section->isEnabled());
        $section->preUpdate();
        $this->entityManager->flush();

        return $section->isEnabled();
    }

    public function deleteSection(string $sectionType): bool
    {
        $section = $this->getSection($sectionType);
        if ($section === null) {
            return false;
        }

        $this->entityManager->remove($section);
        $this->entityManager->flush();

        return true;
    }

    public function reorderSections(array $sectionOrder): void
    {
        foreach ($sectionOrder as $position => $sectionType) {
            $section = $this->getSection($sectionType);
            if ($section !== null) {
                $section->setSortOrder($position);
                $section->preUpdate();
            }
        }
        $this->entityManager->flush();
    }

    public function getLandingPageData(): array
    {
        $sections = $this->getEnabledSections();
        $data = [];

        foreach ($sections as $section) {
            $data[$section->getSectionType()] = $section->getContent();
        }

        return $data;
    }
}
