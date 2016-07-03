<?php
/**
 * This file is part of the PositibeLabs Projects.
 *
 * (c) Pedro Carlos Abreu <pcabreus@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Positibe\Bundle\NewsBundle\Factory;

use Doctrine\ORM\EntityManager;
use Positibe\Bundle\NewsBundle\Entity\Comment;
use Sylius\Component\Resource\Factory\Factory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class CommentFactory
 * @package Positibe\Bundle\NewsBundle\Factory
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class CommentFactory extends Factory
{
    protected $entityManager;

    public function __construct($className, EntityManager $entityManager)
    {
        parent::__construct($className);
        $this->entityManager = $entityManager;
    }

    public function createByPostName($postName)
    {
        if (!$post = $this->entityManager->getRepository('PositibeNewsBundle:Post')->findOneBy(
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
} 