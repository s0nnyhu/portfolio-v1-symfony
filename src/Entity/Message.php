<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\GeneratedValue
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\GeneratedValue
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\GeneratedValue
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\GeneratedValue
     * @ORM\Column(type="datetime")
     */
    private $dateMessage;

    /**
     * @ORM\GeneratedValue
     * @ORM\Column(type="boolean")
     */
    private $isRead;


    public function __construct()
    {
        $this->dateMessage = new \DateTime("now");
        $this->isRead = true;
    }
    

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateMessage()
    {
        return $this->dateMessage;
    }

    /**
     * @param mixed $dateMessage
     *
     * @return self
     */
    public function setDateMessage($dateMessage)
    {
        $this->dateMessage = new \DateTime("now");

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * @param mixed $isRead
     *
     * @return self
     */
    public function setIsRead()
    {
        $this->isRead = true;

        return $this;
    }
}
