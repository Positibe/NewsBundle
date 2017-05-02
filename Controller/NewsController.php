<?php
/**
 * This file is part of the PositibeLabs Projects.
 *
 * (c) Pedro Carlos Abreu <pcabreus@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Positibe\Bundle\NewsBundle\Controller;

use Positibe\Bundle\NewsBundle\Entity\Comment;
use Positibe\Bundle\NewsBundle\Form\Type\FrontendCommentFormType;
use Positibe\Bundle\UniqueViewsBundle\Model\VisitableInterface;
use Positibe\Bundle\UserBundle\Entity\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class NewsController
 * @package Positibe\Bundle\NewsBundle\Controller
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class NewsController extends Controller
{
    /**
     * Render the provided content.
     *
     * When using the publish workflow, enable the publish_workflow.request_listener
     * of the core bundle to have the contentDocument as well as the route
     * checked for being published.
     * We don't need an explicit check in this method.
     *
     * @param Request $request
     * @param object $contentDocument
     * @param string $template Symfony path of the template to render
     *                                 the content document. If omitted, the
     *                                 default template is used.
     *
     * @return Response
     */
    public function indexAction(Request $request, $contentDocument, $template = null)
    {
        $template = $template ?: 'post/index.html.twig';

        $template = str_replace(
            ['{_format}', '{_locale}'],
            [$request->getRequestFormat(), $request->getLocale()],
            $template
        );

        if ($contentDocument instanceof VisitableInterface) {
            $this->get('positibe_unique_views.views_counter')->count($contentDocument);
        }

        $contactData = null;
        if ($this->isGranted('ROLE_USER')) {
            /** @var UserInterface $user */
            $user = $this->getUser();
            $contactData = new Comment();
            $contactData->setUser($user);
            $contactData->setName($user->getName());
            $contactData->setEmail($user->getEmail());
            $contactData->setUrl($user->getUrl());
        }
        $formComment = $this->createForm(
            FrontendCommentFormType::class,
            $contactData,
            ['action' => $this->generateUrl('post_comment_create', ['postName' => $contentDocument->getName()]),]
        );

        $params = ['post' => $contentDocument, 'formComment' => $formComment->createView()];

        return $this->render($template, $params);
    }

    /**
     * @param Request $request
     * @param $contentDocument
     * @param null $template
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request, $contentDocument, $template = null)
    {
        $template = $template ?: 'post/list.html.twig';

        $template = str_replace(
            ['{_format}', '{_locale}'],
            [$request->getRequestFormat(), $request->getLocale()],
            $template
        );

        $posts = $this->get('positibe.repository.post')->createPaginator(
            array_merge(
                $request->get('criteria', []),
                [
                    'state' => 'published',
                    'can_publish_on_date' => new \DateTime('now'),
                ]
            ),
            ['publishStartDate' => 'DESC']
        );
        $posts->setCurrentPage($request->get('page', 1), true, true);

        $params = ['content' => $contentDocument, 'posts' => $posts];


        return $this->render($template, $params);
    }
} 