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

/**
 * Class TagsBlockService
 * @package Positibe\Bundle\NewsBundle\Block
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class TagsBlockService extends CategoriesBlockService
{
    protected $template = 'PositibeNewsBundle:Block:block_tags.html.twig';
    protected $class = 'PositibeNewsBundle:Tag';
} 