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

use Positibe\Bundle\NewsBundle\Entity\Post;
use Positibe\Bundle\OrmMenuBundle\Model\MenuNodeReferrersInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Cmf\Bundle\SeoBundle\SeoAwareInterface;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class PostController
 * @package Positibe\Bundle\NewsBundle\Controller
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class PostController extends ResourceController
{
    /**
     * Load the correct locale for seo and menus depend of data_locale http parameter
     *
     * @param Request $request
     * @param array $criteria
     * @return object|void
     */
    /**
     * @param RequestConfiguration $configuration
     * @return Post|\Sylius\Component\Resource\Model\ResourceInterface
     */
    public function findOr404(RequestConfiguration $configuration)
    {
        /** @var Post $post */
        $post = parent::findOr404($configuration);;

        if ($dataLocale = $configuration->getRequest()->get('data_locale')) {
            $post->setLocale($dataLocale);

            if ($post instanceof SeoAwareInterface && $seoMetadata = $post->getSeoMetadata()) {
                $seoMetadata->setLocale($dataLocale);
                $this->get('doctrine.orm.entity_manager')->refresh($seoMetadata);
            }

            if ($post instanceof MenuNodeReferrersInterface) {
                foreach ($post->getMenuNodes() as $menu) {
                    $menu->setLocale($dataLocale);
                    $this->get('doctrine.orm.entity_manager')->refresh($menu);
                }
            }

            foreach ($post->getCollections() as $collection) {
                $collection->setLocale($dataLocale);
                $this->get('doctrine.orm.entity_manager')->refresh($collection);
            }


            $this->get('doctrine.orm.entity_manager')->refresh($post);
        }

        return $post;
    }
} 