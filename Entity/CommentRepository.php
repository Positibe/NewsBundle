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
use Positibe\Bundle\CmfBundle\Repository\FilterRepository;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class CommentRepository
 * @package Positibe\Bundle\NewsBundle\Entity
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class CommentRepository extends EntityRepository
{
    public function createByPostName($postName)
    {
        if (!$post = $this->getEntityManager()->getRepository('PositibeNewsBundle:Post')->findOneBy(
          array(
            'name' => $postName
          )
        )
        ) {
            throw new NotFoundHttpException('No se encontró la entrada con nombre ' . $postName);
        }
        /** @var Comment $comment */
        $comment = parent::createNew();

        $comment->setPost($post);

        return $comment;

    }

    protected function applyCriteria(QueryBuilder $queryBuilder, array $criteria = array())
    {
        if (isset($criteria['author']) && !empty($criteria['author'])) {
            $queryBuilder->andWhere('o.name LIKE :author OR o.email LIKE :author OR o.url LIKE :author')->setParameter(
              'author',
              '%' . $criteria['author'] . '%'
            );

            unset($criteria['author']);
        }
        $criteria = FilterRepository::filterLike($queryBuilder, $criteria, 'message');
        $criteria = FilterRepository::filterToOneField($queryBuilder, $criteria, 'title', 'post');
        parent::applyCriteria($queryBuilder, $criteria);
    }


} 