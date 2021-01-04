<?php

namespace App\Domain\Application\Repository;

use App\Core\Orm\AbstractRepository;
use App\Core\Orm\IterableQueryBuilder;
use App\Domain\Application\Entity\Content;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<Content>
 */
class ContentRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Content::class);
    }

    /**
     * @return IterableQueryBuilder<Content>
     */
    public function findLatest(int $limit = 5): IterableQueryBuilder
    {
        return $this->createIterableQuery('c')
            ->orderBy('c.createdAt', 'DESC')
            ->where('c.createdAt < NOW()')->andWhere('c.online = TRUE')
            ->setMaxResults($limit);
    }
}
