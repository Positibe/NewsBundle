<?php

namespace Positibe\Bundle\NewsBundle\Doctrine\ORM;

use Pagerfanta\Pagerfanta;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Class NewsRepository
 * @package Positibe\Bundle\NewsBundle\Doctrine\ORM
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class NewsRepository extends EntityRepository
{
    /**
     * Create filter paginator.
     *
     * @param array $criteria
     * @param array $sorting
     * @param bool $deleted
     *
     * @return Pagerfanta
     */
    public function createFilterPaginator($criteria = array(), $sorting = array(), $deleted = false)
    {
        $queryBuilder = parent::getCollectionQueryBuilder()
            ->select('news');

        if (!empty($criteria['title'])) {
            $queryBuilder
                ->andWhere('news.title LIKE :title')
                ->setParameter('title', '%' . $criteria['title'] . '%');
        }

        if (!empty($criteria['about'])) {
            $queryBuilder
                ->andWhere('news.content LIKE :about OR news.abstract LIKE :about')
                ->setParameter('about', '%' . $criteria['about'] . '%');
        }

        if (empty($sorting)) {
            if (!is_array($sorting)) {
                $sorting = array();
            }
            $sorting['updatedAt'] = 'desc';
        }

        $this->applySorting($queryBuilder, $sorting);

        if ($deleted) {
            $this->_em->getFilters()->disable('softdeleteable');
        }

        return $this->getPaginator($queryBuilder);
    }

    protected function getAlias()
    {
        return 'news';
    }
} 