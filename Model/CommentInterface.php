<?php

namespace Positibe\Bundle\NewsBundle\Model;

/**
 * Interface CommentInterface
 * @package Positibe\Bundle\NewsBundle\Model
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
interface CommentInterface
{
    const STATUS_INVALID  = 0;
    const STATUS_VALID    = 1;
    const STATUS_MODERATE = 2;

    public function getId();

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName();

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email);

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail();

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url);

    /**
     * Get url
     *
     * @return string $url
     */
    public function getUrl();

    /**
     * Set message
     *
     * @param string $message
     */
    public function setMessage($message);

    /**
     * Get message
     *
     * @return string $message
     */
    public function getMessage();

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
     * @return \DateTime $updatedAt
     */
    public function getUpdatedAt();

    /**
     * Get text version of comment status
     *
     * @return string|null
     */
    public function getStatusCode();

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status);

    /**
     * Get status
     *
     * @return integer $status
     */
    public function getStatus();

    /**
     * Set News
     *
     * @param NewsInterface $news
     */
    public function setNews($news);

    /**
     * Get News
     *
     * @return NewsInterface $news
     */
    public function getNews();
}
