<?php

namespace App\Entity;

use App\Repository\SegmentsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SegmentsRepository::class)
 */
class Segments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(max=2)
     */
    private $part;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=255)
     */
    private $title1;

    /**
     * @ORM\Column(type="text")
     */
    private $message1;

    /**
     * @ORM\Column(type="text")
     * @Assert\Url()
     */
    private $link1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title2;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=5, max=255)
     */
    private $message2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $link2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $link_s1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $link_s2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $link_s3;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPart(): ?int
    {
        return $this->part;
    }

    public function setPart(int $part): self
    {
        $this->part = $part;

        return $this;
    }

    public function getTitle1(): ?string
    {
        return $this->title1;
    }

    public function setTitle1(string $title1): self
    {
        $this->title1 = $title1;

        return $this;
    }

    public function getMessage1(): ?string
    {
        return $this->message1;
    }

    public function setMessage1(string $message1): self
    {
        $this->message1 = $message1;

        return $this;
    }

    public function getLink1(): ?string
    {
        return $this->link1;
    }

    public function setLink1(string $link1): self
    {
        $this->link1 = $link1;

        return $this;
    }

    public function getTitle2(): ?string
    {
        return $this->title2;
    }

    public function setTitle2(string $title2): self
    {
        $this->title2 = $title2;

        return $this;
    }

    public function getMessage2(): ?string
    {
        return $this->message2;
    }

    public function setMessage2(string $message2): self
    {
        $this->message2 = $message2;

        return $this;
    }

    public function getLink2(): ?string
    {
        return $this->link2;
    }

    public function setLink2(?string $link2): self
    {
        $this->link2 = $link2;

        return $this;
    }

    public function getLinkS1(): ?string
    {
        return $this->link_s1;
    }

    public function setLinkS1(?string $link_s1): self
    {
        $this->link_s1 = $link_s1;

        return $this;
    }

    public function getLinkS2(): ?string
    {
        return $this->link_s2;
    }

    public function setLinkS2(?string $link_s2): self
    {
        $this->link_s2 = $link_s2;

        return $this;
    }

    public function getLinkS3(): ?string
    {
        return $this->link_s3;
    }

    public function setLinkS3(?string $link_s3): self
    {
        $this->link_s3 = $link_s3;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }
}
