<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 */
class Profil implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="10", minMessage="Your password must be at least 10 characters long")
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\Length(min="10", minMessage="Your password must be at least 10 characters long")
     */
    public $new_password;
    
    /**
     * @Assert\Length(min="10", minMessage="Your password must be at least 10 characters long")
     * @Assert\EqualTo(propertyPath="new_password", message="The new password and confirmation password do not match")
     */
    public $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function eraseCredentials() {}

    public function getSalt() {}

    public function getRoles() {
        return ['ROLE_USER'];
    }

}
