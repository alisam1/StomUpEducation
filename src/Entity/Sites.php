<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SitesRepository")
 */
class Sites
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
    private $site_url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $site_phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $site_email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $site_map;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $site_meta_title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $site_meta_description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $site_analitics_ya;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $site_analitics_ga;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $site_main_logo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteUrl(): ?string
    {
        return $this->site_url;
    }

    public function setSiteUrl(string $site_url): self
    {
        $this->site_url = $site_url;

        return $this;
    }

    public function getSitePhone(): ?string
    {
        return $this->site_phone;
    }

    public function setSitePhone(string $site_phone): self
    {
        $this->site_phone = $site_phone;

        return $this;
    }

    public function getSiteEmail(): ?string
    {
        return $this->site_email;
    }

    public function setSiteEmail(string $site_email): self
    {
        $this->site_email = $site_email;

        return $this;
    }

    public function getSiteMap(): ?string
    {
        return $this->site_map;
    }

    public function setSiteMap(string $site_map): self
    {
        $this->site_map = $site_map;

        return $this;
    }

    public function getSiteMetaTitle(): ?string
    {
        return $this->site_meta_title;
    }

    public function setSiteMetaTitle(?string $site_meta_title): self
    {
        $this->site_meta_title = $site_meta_title;

        return $this;
    }

    public function getSiteMetaDescription(): ?string
    {
        return $this->site_meta_description;
    }

    public function setSiteMetaDescription(?string $site_meta_description): self
    {
        $this->site_meta_description = $site_meta_description;

        return $this;
    }

    public function getSiteAnaliticsYa(): ?string
    {
        return $this->site_analitics_ya;
    }

    public function setSiteAnaliticsYa(?string $site_analitics_ya): self
    {
        $this->site_analitics_ya = $site_analitics_ya;

        return $this;
    }

    public function getSiteAnaliticsGa(): ?string
    {
        return $this->site_analitics_ga;
    }

    public function setSiteAnaliticsGa(?string $site_analitics_ga): self
    {
        $this->site_analitics_ga = $site_analitics_ga;

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

    public function getSiteMainLogo(): ?string
    {
        return $this->site_main_logo;
    }

    public function setSiteMainLogo(string $site_main_logo): self
    {
        $this->site_main_logo = $site_main_logo;

        return $this;
    }
}
