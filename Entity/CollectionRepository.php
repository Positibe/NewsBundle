<?php
/**
 * This file is part of the PositibeLabs Projects.
 *
 * (c) Pedro Carlos Abreu <pcabreus@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Positibe\Bundle\NewsBundle\Entity;

use Positibe\Bundle\CoreBundle\Repository\EntityRepository;
use Positibe\Bundle\CoreBundle\Repository\LocaleRepositoryTrait;

/**
 * Class CollectionRepository
 * @package Positibe\Bundle\NewsBundle\Entity
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class CollectionRepository extends EntityRepository
{
    use LocaleRepositoryTrait;

    /**
     * @param null $count
     * @param null $author
     * @param null $preventCurrent
     * @return array
     */
    public function filterForBlock($count = null, $author = null, $preventCurrent = null)
    {
        $qb = $this->createQueryBuilder('o')
//            ->leftJoin('o.posts', 'posts')
//            ->addSelect('COUNT(posts) as postsCount')
//            ->orderBy('postsCount', 'DESC')
//            ->groupBy('o.id')
        ;

        if ($count) {
            $qb->setMaxResults($count);
        }
        if ($author) {
            $qb->join('posts.author', 'author')->andWhere('author = :author')->setParameter('author', $author);
        }
        if ($preventCurrent) {
            $qb->andWhere('o != :current')->setParameter('current', $preventCurrent);
        }

        return $this->getQuery($qb)->getResult();
    }
} 