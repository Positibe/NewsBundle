<?php

namespace Positibe\Bundle\NewsBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class PositibeNewsBundle
 * @package Positibe\Bundle
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class PositibeNewsBundle extends AbstractResourceBundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSupportedDrivers()
    {
        return array(
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getBundlePrefix()
    {
        return 'positibe_news';
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelInterfaces()
    {
        return array(
            'Positibe\Bundle\NewsBundle\Model\NewsInterface'    => 'Positibe\Bundle\NewsBundle\Model\News',
            'Positibe\Bundle\NewsBundle\Model\CommentInterface' => 'Positibe\Bundle\NewsBundle\Model\Comment',
            'Positibe\Bundle\NewsBundle\Model\TagInterface'     => 'Positibe\Bundle\NewsBundle\Model\Tag',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelNamespace()
    {
        return 'Positibe\Bundle\NewsBundle\Model';
    }
}