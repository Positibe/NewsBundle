<?php

namespace Positibe\Bundle\NewsBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Positibe\Bundle\ClassificationBundle\Model\Tag as ClassificationTag;
use Positibe\Bundle\NewsBundle\Model\TagInterface;

/**
 * Class Tag
 * @package Positibe\Bundle\NewsBundle\Model
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class Tag extends ClassificationTag implements TagInterface {
    /**
     * @var News[] | ArrayCollection
     */
    protected $newses;

    public function __construct()
    {
        $this->newses= new ArrayCollection();
    }

    /**
     * @param News $news
     * @return mixed
     */
    public function addNews(News $news)
    {
        if(!$this->newses->contains($news))
        {
            $this->newses[] = $news;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewses()
    {
        return $this->newses;
    }


} 