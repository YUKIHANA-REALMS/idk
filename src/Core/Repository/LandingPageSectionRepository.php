<?php

namespace App\Core\Repository;

use App\Core\Entity\LandingPageSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LandingPageSection>
 */
class LandingPageSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LandingPageSection::class);
    }

    public function findAllEnabled(): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.isEnabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('s.sortOrder', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllSorted(): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.sortOrder', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByType(string $sectionType): ?LandingPageSection
    {
        return $this->createQueryBuilder('s')
            ->where('s.sectionType = :type')
            ->setParameter('type', $sectionType)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getMaxSortOrder(): int
    {
        $result = $this->createQueryBuilder('s')
            ->select('MAX(s.sortOrder)')
            ->getQuery()
            ->getSingleScalarResult();

        return $result ?? 0;
    }
}
