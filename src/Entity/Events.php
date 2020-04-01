<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventsRepository")
 */
class Events
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
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $event_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $event_type;

    /**
     * @ORM\Column(type="json")
     */
    private $event_way;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $event_address;

    /**
     * @ORM\Column(type="datetime")
     */
    private $event_start_time;

    /**
     * @ORM\Column(type="datetime")
     */
    private $event_end_time;

    /**
     * @ORM\Column(type="json")
     */
    private $lector_id;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $event_photos;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $event_description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_free;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_discount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rule_point;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rule_sertificate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $event_main_img;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $event_city;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $event_discount_percent;

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

    public function getEventName(): ?string
    {
        return $this->event_name;
    }

    public function setEventName(string $event_name): self
    {
        $this->event_name = $event_name;

        return $this;
    }

    public function getEventType(): ?int
    {
        return $this->event_type;
    }

    public function setEventType(int $event_type): self
    {
        $this->event_type = $event_type;

        return $this;
    }

    public function getEventWay(): ?array
    {
        return $this->event_way;
    }

    public function setEventWay(array $event_way): self
    {
        $this->event_way = $event_way;

        return $this;
    }

    public function getEventAddress(): ?string
    {
        return $this->event_address;
    }

    public function setEventAddress(string $event_address): self
    {
        $this->event_address = $event_address;

        return $this;
    }

    public function getEventStartTime(): ?\DateTimeInterface
    {
        return $this->event_start_time;
    }

    public function setEventStartTime(\DateTimeInterface $event_start_time): self
    {
        $this->event_start_time = $event_start_time;

        return $this;
    }

    public function getEventEndTime(): ?\DateTimeInterface
    {
        return $this->event_end_time;
    }

    public function setEventEndTime(\DateTimeInterface $event_end_time): self
    {
        $this->event_end_time = $event_end_time;

        return $this;
    }

    public function getLectorId(): ?array
    {
        return $this->lector_id;
    }

    public function setLectorId(array $lector_id): self
    {
        $this->lector_id = $lector_id;

        return $this;
    }

    public function getEventPhotos(): ?array
    {
        return $this->event_photos;
    }

    public function setEventPhotos(?array $event_photos): self
    {
        $this->event_photos = $event_photos;

        return $this;
    }

    public function getEventDescription(): ?string
    {
        return $this->event_description;
    }

    public function setEventDescription(?string $event_description): self
    {
        $this->event_description = $event_description;

        return $this;
    }

    public function getIsFree(): ?bool
    {
        return $this->is_free;
    }

    public function setIsFree(?bool $is_free): self
    {
        $this->is_free = $is_free;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsDiscount(): ?bool
    {
        return $this->is_discount;
    }

    public function setIsDiscount(?bool $is_discount): self
    {
        $this->is_discount = $is_discount;

        return $this;
    }

    public function getRulePoint(): ?int
    {
        return $this->rule_point;
    }

    public function setRulePoint(?int $rule_point): self
    {
        $this->rule_point = $rule_point;

        return $this;
    }

    public function getRuleSertificate(): ?bool
    {
        return $this->rule_sertificate;
    }

    public function setRuleSertificate(?bool $rule_sertificate): self
    {
        $this->rule_sertificate = $rule_sertificate;

        return $this;
    }

    public function getEventMainImg(): ?string
    {
        return $this->event_main_img;
    }

    public function setEventMainImg(string $event_main_img): self
    {
        $this->event_main_img = $event_main_img;

        return $this;
    }

    public function getEventCity(): ?string
    {
        return $this->event_city;
    }

    public function setEventCity(string $event_city): self
    {
        $this->event_city = $event_city;

        return $this;
    }

    public function getEventDiscountPercent(): ?int
    {
        return $this->event_discount_percent;
    }

    public function setEventDiscountPercent(?int $event_discount_percent): self
    {
        $this->event_discount_percent = $event_discount_percent;

        return $this;
    }
}
