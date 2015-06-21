<?php

namespace Positibe\Bundle\NewsBundle\Model;

use Positibe\Bundle\ClassificationBundle\Model\TagInterface as ClassificationTagInterface;
/**
 * Interface TagInterface
 * @package Positibe\Bundle\NewsBundle\Model
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
interface TagInterface extends ClassificationTagInterface {

    /**
     * @param News $news
     * @return ClassificationTagInterface
     */
    public function addNews(News $news);

    /**
     * @return NewsInterface
     */
    public function getNewses();
} 