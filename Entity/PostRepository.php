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
use Positibe\Bundle\OrmContentBundle\Entity\Traits\PageRepositoryTrait;
use Positibe\Bundle\OrmRoutingBundle\Entity\HasRoutesRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;


/**
 * Class PostRepository
 * @package Positibe\Bundle\NewsBundle\Entity
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class PostRepository extends EntityRepository implements HasRoutesRepositoryInterface {

    private $locale;

    /**
     * @param mixed $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

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

    public function getQuery(QueryBuilder $qb)
    {
        $query = $qb->getQuery();

        if ($this->locale) {
            $query->setHint(
              TranslatableListener::HINT_TRANSLATABLE_LOCALE,
              $this->locale // take locale from session or request etc.
            );

            $query->setHint(
              TranslatableListener::HINT_FALLBACK,
              1 // fallback to default values in case if record is not translated
            );
        }

        $query->setHint(
          Query::HINT_CUSTOM_OUTPUT_WALKER,
          'Positibe\\Bundle\\CmfBundle\\Doctrine\\Query\\TranslationWalker'
        );
        return $query;
    }
} 