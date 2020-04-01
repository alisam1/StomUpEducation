<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessagesRepository")
 */
class Messages
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $from_user_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $to_user_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $file_link = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_read;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromUserId(): ?int
    {
        return $this->from_user_id;
    }

    public function setFromUserId(int $from_user_id): self
    {
        $this->from_user_id = $from_user_id;

        return $this;
    }

    public function getToUserId(): ?int
    {
        return $this->to_user_id;
    }

    public function setToUserId(int $to_user_id): self
    {
        $this->to_user_id = $to_user_id;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getFileLink(): ?array
    {
        return $this->file_link;
    }

    public function setFileLink(?array $file_link): self
    {
        $this->file_link = $file_link;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->is_read;
    }

    public function setIsRead(bool $is_read): self
    {
        $this->is_read = $is_read;

        return $this;
    }
}
