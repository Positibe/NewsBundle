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

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Gedmo\Translatable\TranslatableListener;
use Positibe\Bundle\CmfBundle\Repository\LocaleRepositoryTrait;
use Positibe\Bundle\OrmContentBundle\Entity\Traits\PageRepositoryTrait;
use Positibe\Bundle\OrmRoutingBundle\Entity\HasRoutesRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;


/**
 * Class PostRepository
 * @package Positibe\Bundle\NewsBundle\Entity
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class PostRepository extends EntityRepository implements HasRoutesRepositoryInterface
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

    public function findLastNews($count)
    {
        $qb = $this->createQueryBuilder('o')
          ->addSelect('image', 'routes')
          ->leftJoin('o.image', 'image')
          ->leftJoin('o.routes', 'routes')
          ->setMaxResults($count)->orderBy(
            'o.publishStartDate',
            'DESC'
          );

        return $this->getQuery($qb)->getResult();
    }
} 