<?php

namespace Positibe\Bundle\NewsBundle\Doctrine\ORM;

use Pagerfanta\Pagerfanta;
use Positibe\Bundle\NewsBundle\Model\Comment;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Class NewsRepository
 * @package Positibe\Bundle\NewsBundle\Doctrine\ORM
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class CommentRepository extends EntityRepository
{
    public function createNewComment($slug)
    {
        /** @var Comment $comment */
        $comment = parent::createNew();
        $newsRepository = $this->getEntityManager()->getRepository('Positibe\Bundle\NewsBundle\Model\News');

        $news = $newsRepository->findOneBy(array(
                'slug' => $slug
            ));

        $comment->setNews($news);
        $news->addComments($comment);

        return $comment;
    }

    protected function getAlias()
    {
        return 'comment';
    }
} 