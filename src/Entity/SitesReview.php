<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SitesReviewRepository")
 */
class SitesReview
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
    private $site_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reviewer_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reviewer_worker_position;

    /**
     * @ORM\Column(type="text")
     */
    private $reviewer_text;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteId(): ?int
    {
        return $this->site_id;
    }

    public function setSiteId(int $site_id): self
    {
        $this->site_id = $site_id;

        return $this;
    }

    public function getReviewerName(): ?string
    {
        return $this->reviewer_name;
    }

    public function setReviewerName(string $reviewer_name): self
    {
        $this->reviewer_name = $reviewer_name;

        return $this;
    }

    public function getReviewerWorkerPosition(): ?string
    {
        return $this->reviewer_worker_position;
    }

    public function setReviewerWorkerPosition(string $reviewer_worker_position): self
    {
        $this->reviewer_worker_position = $reviewer_worker_position;

        return $this;
    }

    public function getReviewerText(): ?string
    {
        return $this->reviewer_text;
    }

    public function setReviewerText(string $reviewer_text): self
    {
        $this->reviewer_text = $reviewer_text;

        return $this;
    }
}
