<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Skeleton\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use KejawenLab\Semart\Skeleton\Entity\Todo;
use KejawenLab\Semart\Skeleton\Util\StringUtil;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class TodoRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Todo::class);
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?object
    {
        $key = md5(sprintf('%s:%s:%s:%s', __CLASS__, __METHOD__, serialize($criteria), serialize($orderBy)));

        return $this->doFindOneBy($key, $criteria, $orderBy);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        $key = md5(sprintf('%s:%s:%s:%s:%s:%s', __CLASS__, __METHOD__, serialize($criteria), serialize($orderBy), $limit, $offset));

        return $this->doFindBy($key, $criteria, $orderBy, $limit, $offset);
    }

    public function getData(string $like = null, $offset = null, $limit, $count = null) {

        $queryBuilder = $this->createQueryBuilder('o');

        $queryBuilder->select('o');

        if(!empty($like)) {
            $queryBuilder->orWhere($queryBuilder->expr()->like('o.name', $queryBuilder->expr()->literal(sprintf('%%%s%%', StringUtil::uppercase($like)))));
        }

        if(!empty($limit) && $count == NULL) {
            $queryBuilder->setFirstResult($limit);
        }

        if(!empty($offset) && $count == NULL) {
            $queryBuilder->setMaxResults($offset);
        }

        $query = $queryBuilder->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 1, serialize($query->getParameters()));

        if($count !== NULL) {
            return count($query->getResult());
        } else {
            return $query->getResult();
        }

    }
}
