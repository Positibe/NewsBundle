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

use Positibe\Bundle\CmfBundle\Repository\LocaleRepositoryTrait;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;


/**
 * Class CollectionRepository
 * @package Positibe\Bundle\NewsBundle\Entity
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class CollectionRepository extends EntityRepository
{
    use LocaleRepositoryTrait;
} 