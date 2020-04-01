<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserDetailsRepository")
 */
class UserDetails
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $full_name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $inn;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $kpp;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ogrn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jur_name;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $jur_address;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $fiz_address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $worker_position;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $worker_city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo_link;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $dop_phones = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user_points;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInn(): ?string
    {
        return $this->inn;
    }

    public function setInn(?string $inn): self
    {
        $this->inn = $inn;

        return $this;
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

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(?string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getKpp(): ?string
    {
        return $this->kpp;
    }

    public function setKpp(?string $kpp): self
    {
        $this->kpp = $kpp;

        return $this;
    }

    public function getOgrn(): ?string
    {
        return $this->ogrn;
    }

    public function setOgrn(?string $ogrn): self
    {
        $this->ogrn = $ogrn;

        return $this;
    }

    public function getJurName(): ?string
    {
        return $this->jur_name;
    }

    public function setJurName(?string $jur_name): self
    {
        $this->jur_name = $jur_name;

        return $this;
    }

    public function getJurAddress(): ?array
    {
        return $this->jur_address;
    }

    public function setJurAddress(?array $jur_address): self
    {
        $this->jur_address = $jur_address;

        return $this;
    }

    public function getFizAddress(): ?array
    {
        return $this->fiz_address;
    }

    public function setFizAddress(?array $fiz_address): self
    {
        $this->fiz_address = $fiz_address;

        return $this;
    }

    public function getWorkerPosition(): ?string
    {
        return $this->worker_position;
    }

    public function setWorkerPosition(?string $worker_position): self
    {
        $this->worker_position = $worker_position;

        return $this;
    }

    public function getWorkerCity(): ?string
    {
        return $this->worker_city;
    }

    public function setWorkerCity(?string $worker_city): self
    {
        $this->worker_city = $worker_city;

        return $this;
    }

    public function getPhotoLink(): ?string
    {
        return $this->photo_link;
    }

    public function setPhotoLink(?string $photo_link): self
    {
        $this->photo_link = $photo_link;

        return $this;
    }

    public function getDopPhones(): ?array
    {
        return $this->dop_phones;
    }

    public function setDopPhones(?array $dop_phones): self
    {
        $this->dop_phones = $dop_phones;

        return $this;
    }

    public function getUserPoints(): ?int
    {
        return $this->user_points;
    }

    public function setUserPoints(?int $user_points): self
    {
        $this->user_points = $user_points;

        return $this;
    }
}
