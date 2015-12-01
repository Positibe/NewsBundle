<?php

namespace Positibe\Bundle\NewsBundle\Model;

use Positibe\Bundle\SeoRouteBundle\Extractor\SeoReadInterface;
use Positibe\Bundle\UniqueViewsBundle\Model\VisitableInterface;
use Sonata\MediaBundle\Model\MediaInterface;

/***
 * Interface NewsInterface
 * @package Positibe\Bundle\NewsBundle\Model
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
interface NewsInterface extends VisitableInterface, SeoReadInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle();

    /**
     * Set abstract
     *
     * @param string $abstract
     */
    public function setAbstract($abstract);

    /**
     * Get abstract
     *
     * @return string $abstract
     */
    public function getAbstract();

    /**
     * Set content
     *
     * @param string $content
     */
    public function setContent($content);

    /**
     * Get content
     *
     * @return string $content
     */
    public function getContent();

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled);

    /**
     * Get enabled
     *
     * @return boolean $enabled
     */
    public function getEnabled();

    /**
     * Set slug
     *
     * @param integer $slug
     */
    public function setSlug($slug);

    /**
     * Get slug
     *
     * @return integer $slug
     */
    public function getSlug();

    /**
     * Set publication_date_start
     *
     * @param \DateTime $publicationDateStart
     */
    public function setPublicationDateStart(\DateTime $publicationDateStart = null);

    /**
     * Get publication_date_start
     *
     * @return \DateTime $publicationDateStart
     */
    public function getPublicationDateStart();

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt = null);

    /**
     * Get created_at
     *
     * @return \DateTime $createdAt
     */
    public function getCreatedAt();

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt = null);

    /**
     * Get updated_at
     *
     * @return \Datetime $updatedAt
     */
    public function getUpdatedAt();

    /**
     * Add comments
     *
     * @param \Positibe\Bundle\NewsBundle\Model\CommentInterface $comments
     */
    public function addComments(CommentInterface $comments);

    /**
     *
     * @param array $comments
     */
    public function setComments($comments);

    /**
     * Get comments
     *
     * @return array $comments
     */
    public function getComments();

    /**
     * Add tags
     *
     * @param TagInterface $tags
     */
    public function addTags(TagInterface $tags);

    /**
     * Get tags
     *
     * @return array $tags
     */
    public function getTags();

    /**
     * @param $tags
     *
     * @return mixed
     */
    public function setTags($tags);

    /**
     * @return string
     */
    public function getYear();

    /**
     * @return string
     */
    public function getMonth();

    /**
     * @return string
     */
    public function getDay();

    /**
     * Set comments_enabled
     *
     * @param boolean $commentsEnabled
     */
    public function setCommentsEnabled($commentsEnabled);

    /**
     * Get comments_enabled
     *
     * @return boolean $commentsEnabled
     */
    public function getCommentsEnabled();

    /**
     * Set comments_close_at
     *
     * @param \DateTime $commentsCloseAt
     */
    public function setCommentsCloseAt(\DateTime $commentsCloseAt = null);

    /**
     * Get comments_close_at
     *
     * @return \DateTime $commentsCloseAt
     */
    public function getCommentsCloseAt();

    /**
     * Set comments_default_status
     *
     * @param integer $commentsDefaultStatus
     */
    public function setCommentsDefaultStatus($commentsDefaultStatus);

    /**
     * Get comments_default_status
     *
     * @return integer $commentsDefaultStatus
     */
    public function getCommentsDefaultStatus();

    /**
     * Set comments_count
     *
     * @param integer $commentscount
     */
    public function setCommentsCount($commentscount);

    /**
     * Get comments_count
     *
     * @return integer $commentsCount
     */
    public function getCommentsCount();

    /**
     * @return boolean
     */
    public function isCommentable();

    /**
     * @return boolean
     */
    public function isPublic();

    /**
     * @param mixed $author
     *
     * @return mixed
     */
    public function setAuthor($author);

    /**
     * @return mixed
     */
    public function getAuthor();

    /**
     * @param MediaInterface $image
     *
     * @return MediaInterface
     */
    public function setImage($image);

    /**
     * @return MediaInterface
     */
    public function getImage();

//    /**
//     * @param string $contentFormatter
//     */
//    public function setContentFormatter($contentFormatter);
//
//    /**
//     * @return string
//     */
//    public function getContentFormatter();
//
//    /**
//     * @param string $rawContent
//     */
//    public function setRawContent($rawContent);
//
//    /**
//     * @return string
//     */
//    public function getRawContent();
}
