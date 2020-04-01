<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LectorsRepository")
 */
class Lectors
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $full_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $worker_position;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $verification_user_id;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $in_centers;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $about;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getWorkerPosition(): ?string
    {
        return $this->worker_position;
    }

    public function setWorkerPosition(string $worker_position): self
    {
        $this->worker_position = $worker_position;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getVerificationUserId(): ?int
    {
        return $this->verification_user_id;
    }

    public function setVerificationUserId(?int $verification_user_id): self
    {
        $this->verification_user_id = $verification_user_id;

        return $this;
    }

    public function getInCenters(): ?array
    {
        return $this->in_centers;
    }

    public function setInCenters(?array $in_centers): self
    {
        $this->in_centers = $in_centers;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }
}
