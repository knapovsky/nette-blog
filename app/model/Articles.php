<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Articles extends \Kdyby\Doctrine\Entities\BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Model\Users", inversedBy="articles", cascade={"persist"})
     * @var \App\Model\Users
     */
    protected $user;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string", nullable=TRUE)
     * @var string
     */
    protected $pictureURL;

    /**
     * @ORM\Column(type="string", nullable=TRUE)
     * @var string
     */
    protected $perex;

    /**
     * @ORM\Column(type="text", nullable=TRUE)
     * @var string
     */
    protected $text;

    /**
     * @ORM\Column(type="datetime")
     * @var datetime
     */
    protected $createdDate;

    /**
     * @ORM\Column(type="datetime")
     * @var datetime
     */
    protected $updatedDate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param Users $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getPictureURL()
    {
        return $this->pictureURL;
    }

    /**
     * @param string $pictureURL
     */
    public function setPictureURL($pictureURL)
    {
        $this->pictureURL = $pictureURL;
    }

    /**
     * @return string
     */
    public function getPerex()
    {
        return $this->perex;
    }

    /**
     * @param string $perex
     */
    public function setPerex($perex)
    {
        $this->perex = $perex;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }


}