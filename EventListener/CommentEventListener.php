<?php
/**
 * This file is part of the PositibeLabs Projects.
 *
 * (c) Pedro Carlos Abreu <pcabreus@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Positibe\Bundle\NewsBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Positibe\Bundle\NewsBundle\Entity\Comment;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * Class CommentEventListener
 * @package Positibe\Bundle\NewsBundle\EventListener
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class CommentEventListener implements EventSubscriberInterface
{
    protected $manager;
    protected $session;

    public function __construct(EntityManager $manager, Session $session)
    {
        $this->manager = $manager;
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return [
            'positibe.post_comment.pre_create' => 'onCreate',
            'positibe.post_comment.pre_update' => 'onCreate',
            'positibe.post_comment.post_create' => 'postCreate',
        ];
    }

    public function onCreate(GenericEvent $event)
    {
        /** @var Comment $comment */
        $comment = $event->getSubject();
        if (!$comment->getUser() && $user = $this->manager->getRepository('AppBundle:User')->findOneBy(
                ['email' => $comment->getEmail()]
            )
        ) {
            $comment->setUser($user);
        }
    }

    public function postCreate(GenericEvent $event)
    {
        $comments = $this->session->get('comments');
        $comments[$event->getSubject()->getId()] = true;
        $this->session->set('comments', $comments);
    }
}