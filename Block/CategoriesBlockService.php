<?php
/**
 * This file is part of the PositibeLabs Projects.
 *
 * (c) Pedro Carlos Abreu <pcabreus@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Positibe\Bundle\NewsBundle\Block;

use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CategoriesBlockService
 * @package Positibe\Bundle\NewsBundle\Block
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class CategoriesBlockService extends AbstractBlockService
{
    protected $template = 'PositibeNewsBundle:Block:block_categories.html.twig';
    protected $em;
    protected $class = 'PositibeNewsBundle:Collection';

    /**
     * @param null|string $name
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     * @param EntityManager $entityManager
     */
    public function __construct($name, $templating, EntityManager $entityManager)
    {
        parent::__construct($name, $templating);
        $this->em = $entityManager;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (!$response) {
            $response = new Response();
        }

        $newsPage = $this->em->getRepository('PositibeCmsBundle:Page')->findOneBy(['customController' => 'Noticias']);

        if (!$contents = $blockContext->getSetting('contents')) {
            $contents = $this->em->getRepository($this->class)->filterForBlock(
                $blockContext->getSetting('count'),
                $blockContext->getSetting('by_author'),
                $blockContext->getSetting('prevent_current')
            );
        }

        if (count($contents) > 0) {
            $response = $this->renderResponse(
                $blockContext->getTemplate(),
                array(
                    'block' => $blockContext->getBlock(),
                    'contents' => $contents,
                    'newsPage' => $newsPage,
                ),
                $response
            );
        }

        $response->setTtl($blockContext->getSetting('ttl'));

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'template' => $this->template,
                'count' => null,
                'by_author' => null,
                'prevent_current' => null,
                'contents' => null,
            ]
        );
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function getCacheKeys(BlockInterface $block)
    {
        return ['type' => $block->getType()];
    }
} 