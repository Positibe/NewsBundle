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

use Doctrine\ORM\QueryBuilder;
use Positibe\Bundle\CmsBundle\Repository\BaseContentRepositoryUtil;
use Positibe\Bundle\CoreBundle\Repository\EntityRepository;
use Positibe\Bundle\CoreBundle\Repository\FilterRepository;
use Positibe\Bundle\CoreBundle\Repository\LocaleRepositoryTrait;


/**
 * Class PostRepository
 * @package Positibe\Bundle\NewsBundle\Entity
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class PostRepository extends EntityRepository
{
    use LocaleRepositoryTrait;

    public function findOneByRoutes($route)
    {
        $qb = $this->createQueryBuilder('o')
            ->addSelect('seo', 'image', 'r')
            ->leftJoin('o.image', 'image')
            ->leftJoin('o.seoMetadata', 'seo')
            ->join('o.routes', 'r')
            ->where('r = :route')
            ->setParameter('route', $route);

        return $this->getQuery($qb)->getOneOrNullResult();
    }

    public function findLastNews($count, $author = null, $preventCurrent = null, $order = null)
    {
        $qb = $this->createQueryBuilder('o')
            ->addSelect('image')
            ->leftJoin('o.image', 'image')
            ->setMaxResults($count);

        if ($author) {
            $qb->join('o.author', 'author')->andWhere('author = :author')->setParameter('author', $author);
        }
        if ($preventCurrent) {
            $qb->andWhere('o != :current')->setParameter('current', $preventCurrent);
        }
        $criteria = ['can_publish_on_date' => new \DateTime('now')];

        BaseContentRepositoryUtil::canPublishOnDate($qb, $criteria);
        BaseContentRepositoryUtil::joinRoutes($qb, $this->locale);

        if ($order === 'by_views') {
            $qb->orderBy('o.countViews', 'DESC');
        } else {
            $qb->orderBy('o.publishStartDate', 'DESC');
        }

        return $this->getQuery($qb)->getResult();
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array $criteria
     */
    protected function applyCriteria(QueryBuilder $queryBuilder, array $criteria = [])
    {
        BaseContentRepositoryUtil::canPublishOnDate($queryBuilder, $criteria);
        BaseContentRepositoryUtil::joinRoutes($queryBuilder, $this->locale);
        FilterRepository::filterToOneField($queryBuilder, $criteria, 'category', 'collections', false, 'o', 'name');
        FilterRepository::filterToOneField($queryBuilder, $criteria, 'tag', 'tags', false, 'o', 'name');

        parent::applyCriteria($queryBuilder, $criteria);
    }

} 