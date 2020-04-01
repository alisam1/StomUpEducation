<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRequestRepository")
 */
class EventRequest
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $event_id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pay_status;

    /**
     * @ORM\Column(type="integer")
     */
    private $center_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $req_full_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $req_city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $req_phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $req_comment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_created;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $req_email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getEventId(): ?int
    {
        return $this->event_id;
    }

    public function setEventId(int $event_id): self
    {
        $this->event_id = $event_id;

        return $this;
    }

    public function getPayStatus(): ?bool
    {
        return $this->pay_status;
    }

    public function setPayStatus(?bool $pay_status): self
    {
        $this->pay_status = $pay_status;

        return $this;
    }

    public function getCenterId(): ?int
    {
        return $this->center_id;
    }

    public function setCenterId(int $center_id): self
    {
        $this->center_id = $center_id;

        return $this;
    }

    public function getReqFullName(): ?string
    {
        return $this->req_full_name;
    }

    public function setReqFullName(?string $req_full_name): self
    {
        $this->req_full_name = $req_full_name;

        return $this;
    }

    public function getReqCity(): ?string
    {
        return $this->req_city;
    }

    public function setReqCity(?string $req_city): self
    {
        $this->req_city = $req_city;

        return $this;
    }

    public function getReqPhone(): ?string
    {
        return $this->req_phone;
    }

    public function setReqPhone(?string $req_phone): self
    {
        $this->req_phone = $req_phone;

        return $this;
    }

    public function getReqComment(): ?string
    {
        return $this->req_comment;
    }

    public function setReqComment(?string $req_comment): self
    {
        $this->req_comment = $req_comment;

        return $this;
    }

    public function getDateCreated(): ?string
    {
        return $this->date_created;
    }

    public function setDateCreated(string $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getReqEmail(): ?string
    {
        return $this->req_email;
    }

    public function setReqEmail(?string $req_email): self
    {
        $this->req_email = $req_email;

        return $this;
    }
}
