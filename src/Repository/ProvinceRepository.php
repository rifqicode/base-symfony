<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Skeleton\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use KejawenLab\Semart\Skeleton\Entity\Province;


/**
 * @author Muhammad Rifqi <muhammadrifqi.tb@gmail.com>
 */
class ProvinceRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Province::class);
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

    public function findByCode(string $code): ?Menu
    {
        /** @var Menu|null $menu */
        $menu = $this->findOneBy(['code' => $code]);

        return $menu;
    }

    public function commit(Menu $menu): void
    {
        $this->_em->persist($menu);
        $this->_em->flush();
    }
}
