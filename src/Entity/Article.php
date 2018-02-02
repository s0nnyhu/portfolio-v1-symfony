<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string")
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublic;


    /**
     * @ORM\Column(type="string")
     */
    private $frontDescription;

    /**
     * @ORM\Column(type="string")
     */
    private $frontUrlImg;

    

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     *
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * @param mixed $isPublic
     *
     * @return self
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFrontDescription()
    {
        return $this->frontDescription;
    }

    /**
     * @param mixed $frontDescription
     *
     * @return self
     */
    public function setFrontDescription($frontDescription)
    {
        $this->frontDescription = $frontDescription;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFrontUrlImg()
    {
        return $this->frontUrlImg;
    }

    /**
     * @param mixed $frontUrlImg
     *
     * @return self
     */
    public function setFrontUrlImg($frontUrlImg)
    {
        $this->frontUrlImg = $frontUrlImg;

        return $this;
    }
}
