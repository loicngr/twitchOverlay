<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $login = null;

    #[ORM\Column(length: 255)]
    protected ?string $displayName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $description = null;

    #[ORM\Column(length: 255)]
    protected ?string $email = null;

    #[ORM\Column]
    protected ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    protected ?int $viewCount = null;

    #[ORM\Column(length: 300, nullable: true)]
    protected ?string $profilePicture = null;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Stream::class, orphanRemoval: true)]
    protected ?Collection $streams = null;

    public function __construct()
    {
        $this->streams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }

    public function setViewCount(?int $viewCount): self
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): self
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    /**
     * @return Collection<Stream>
     */
    public function getStreams(): Collection
    {
        return $this->streams ??= new ArrayCollection();
    }

    public function addStream(Stream $stream): self
    {
        if (!$this->streams->contains($stream)) {
            $this->streams->add($stream);
            $stream->setUserId($this);
        }

        return $this;
    }

    public function removeStream(Stream $stream): self
    {
        if ($this->streams->removeElement($stream)) {
            // set the owning side to null (unless already changed)
            if ($stream->getUserId() === $this) {
                $stream->setUserId(null);
            }
        }

        return $this;
    }
}