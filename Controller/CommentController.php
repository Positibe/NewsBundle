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
use Positibe\Bundle\UserBundle\Entity\UserInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Resource\Exception\UpdateHandlingException;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class CommentController
 * @package Positibe\Bundle\NewsBundle\Controller
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class CommentController extends PostController
{
    public function updateMessageAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $this->isGrantedOr403($configuration, ResourceActions::UPDATE);
        /** @var Comment $resource */
        $resource = $this->findOr404($configuration);

        if ($this->isCsrfTokenValid($resource->getSlug(), $request->get('_csrf_token')) &&
            $message = $request->get('message')
        ) {
            $resource->setMessage($message);
            if(!$this->isGranted('ROLE_MODERATOR')) {
                $workflow = $this->get('workflow.registry')->get($resource);
                if ($workflow->can($resource, 'to_review')) {
                    $workflow->apply($resource, 'to_review');
                }
            }

            /** @var ResourceControllerEvent $event */
            $event = $this->eventDispatcher->dispatchPreEvent(ResourceActions::UPDATE, $configuration, $resource);

            if ($event->isStopped()) {
                throw new HttpException($event->getErrorCode(), $event->getMessage());
            }

            try {
                $this->resourceUpdateHandler->handle($resource, $configuration, $this->manager);
            } catch (UpdateHandlingException $exception) {
                return new JsonResponse(null, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

            $postEvent = $this->eventDispatcher->dispatchPostEvent(ResourceActions::UPDATE, $configuration, $resource);

            return new JsonResponse(nl2br($resource->getMessage()));
        }

        return new JsonResponse(null, JsonResponse::HTTP_BAD_REQUEST);
    }

    public function replyMessageAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::CREATE);
        /** @var Comment $newResource */
        $newResource = $this->newResourceFactory->create($configuration, $this->factory);
        if ($this->isCsrfTokenValid($request->get('slug'), $request->get('_csrf_token')) &&
            $message = $request->get('message')
        ) {
            $form = $this->resourceFormFactory->create($configuration, $newResource);

            $newResource = $form->getData();
            $newResource->setMessage($message);
            /** @var UserInterface $user */
            $user = $this->getUser();
            $newResource->setName($user->getName());
            $newResource->setEmail($user->getEmail());
            $newResource->setUrl($user->getUrl());

            $event = $this->eventDispatcher->dispatchPreEvent(ResourceActions::CREATE, $configuration, $newResource);

            if ($event->isStopped()) {
                throw new HttpException($event->getErrorCode(), $event->getMessage());
            }

            try {
                $this->repository->add($newResource);
            } catch (UpdateHandlingException $exception) {
                return new JsonResponse(null, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
            $this->eventDispatcher->dispatchPostEvent(ResourceActions::CREATE, $configuration, $newResource);

            return new JsonResponse(nl2br($newResource->getMessage()));
        }

        return new JsonResponse(null, JsonResponse::HTTP_BAD_REQUEST);
    }

    public function deleteMultipleAction(Request $request)
    {
        $resources = $request->get('app_comment_delete_multiple');

        $repository = $this->getDoctrine()->getRepository($this->metadata->getClass('model'));
        $manager = $this->getDoctrine()->getManager();
        foreach ($resources as $id) {
            if ($resource = $repository->find($id)) {
                $manager->remove($resource);
            }
        }
        $manager->flush();

        return $this->redirect($request->server->get('HTTP_REFERER'));
    }
}