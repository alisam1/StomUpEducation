<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SitesInfoRepository")
 */
class SitesInfo
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
    private $site_info_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $site_info_station;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $site_info_worktime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $site_info_street;

    /**
     * @ORM\Column(type="text")
     */
    private $site_info_about;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $site_info_logo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $site_info_city;

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

    public function getSiteInfoName(): ?string
    {
        return $this->site_info_name;
    }

    public function setSiteInfoName(string $site_info_name): self
    {
        $this->site_info_name = $site_info_name;

        return $this;
    }

    public function getSiteInfoStation(): ?string
    {
        return $this->site_info_station;
    }

    public function setSiteInfoStation(string $site_info_station): self
    {
        $this->site_info_station = $site_info_station;

        return $this;
    }

    public function getSiteInfoWorktime(): ?string
    {
        return $this->site_info_worktime;
    }

    public function setSiteInfoWorktime(string $site_info_worktime): self
    {
        $this->site_info_worktime = $site_info_worktime;

        return $this;
    }

    public function getSiteInfoStreet(): ?string
    {
        return $this->site_info_street;
    }

    public function setSiteInfoStreet(string $site_info_street): self
    {
        $this->site_info_street = $site_info_street;

        return $this;
    }

    public function getSiteInfoAbout(): ?string
    {
        return $this->site_info_about;
    }

    public function setSiteInfoAbout(string $site_info_about): self
    {
        $this->site_info_about = $site_info_about;

        return $this;
    }

    public function getSiteInfoLogo(): ?string
    {
        return $this->site_info_logo;
    }

    public function setSiteInfoLogo(string $site_info_logo): self
    {
        $this->site_info_logo = $site_info_logo;

        return $this;
    }

    public function getSiteInfoCity(): ?string
    {
        return $this->site_info_city;
    }

    public function setSiteInfoCity(string $site_info_city): self
    {
        $this->site_info_city = $site_info_city;

        return $this;
    }
}
