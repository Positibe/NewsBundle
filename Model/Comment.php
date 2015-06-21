<?php

namespace Positibe\Bundle\NewsBundle\Model;

/**
 * Class Comment
 * @package Positibe\Bundle\NewsBundle\Model
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class Comment implements CommentInterface
{
    protected $id;
    /**
     * Name of the author
     *
     * @var string
     */
    protected $name;

    /**
     * Email of the author
     *
     * @var string
     */
    protected $email;

    /**
     * Website url of the author
     *
     * @var string
     */
    protected $url;

    /**
     * Comment content
     *
     * @var string
     */
    protected $message;

    /**
     * Comment created date
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Last update date
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * Moderation status
     *
     * @var int
     */
    protected $status = self::STATUS_VALID;

    /**
     * News for which the comment is related to
     *
     * @var NewsInterface
     */
    protected $news;

    public function getId()
    {
        return $this->id;
    }


    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public static function getStatusList()
    {
        return array(
            self::STATUS_MODERATE => 'moderate',
            self::STATUS_INVALID => 'invalid',
            self::STATUS_VALID   => 'valid',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        $status = self::getStatusList();

        return isset($status[$this->getStatus()]) ? $status[$this->getStatus()] : null;
    }

    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime);
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setNews($news)
    {
        $this->news = $news;
    }

    /**
     * {@inheritdoc}
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName() ?: 'n-a';
    }
}
