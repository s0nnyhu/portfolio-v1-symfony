<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 */
class File
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
    private $fileName;

    /**
     * @ORM\Column(type="string")
     */
    private $fileType;

    /**
     * @ORM\Column(type="string")
     */
    private $fileDescription;

    /**
     * @ORM\Column(type="string")
     */
    private $fileSize;

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of fileName.
     *
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Sets the value of fileName.
     *
     * @param mixed $fileName the file name
     *
     * @return self
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Gets the value of fileType.
     *
     * @return mixed
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * Sets the value of fileType.
     *
     * @param mixed $fileType the file type
     *
     * @return self
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * Gets the value of fileDescription.
     *
     * @return mixed
     */
    public function getFileDescription()
    {
        return $this->fileDescription;
    }

    /**
     * Sets the value of fileDescription.
     *
     * @param mixed $fileDescription the file description
     *
     * @return self
     */
    public function setFileDescription($fileDescription)
    {
        $this->fileDescription = $fileDescription;

        return $this;
    }

    /**
     * Gets the value of fileDescription.
     *
     * @return mixed
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * Sets the value of fileDescription.
     *
     * @param mixed $fileDescription the file description
     *
     * @return self
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;

        return $this;
    }


}
