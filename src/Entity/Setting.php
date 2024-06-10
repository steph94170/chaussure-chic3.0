<?php

namespace App\Entity;

use App\Repository\SettingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SettingRepository::class)]
class Setting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Le nom du site est obligatoire")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le mot du site ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[ORM\Column(length: 255)]
    private ?string $websiteName = null;

    #[Assert\NotBlank(message: "l'url du site est obligatoire")]
    #[Assert\Length(
        max: 255,
        maxMessage: "L'url du site ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[Assert\Url(message: "L'url n'est pas correcte.")]
    #[ORM\Column(length: 255)]
    private ?string $websiteUrl = null;

    #[Assert\NotBlank(message: "La description est obligatoire")]
    #[Assert\Length(
        max: 255,
        maxMessage: "La description ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Length(
        max: 180,
        maxMessage: "L'email ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[Assert\Email(
        message: "L'email {{ value }} n'est pas valide.",
    )]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Assert\NotBlank(message: "Le numero de téléphone est obligatoire")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le numéro de téléphone ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[Assert\Regex(
        pattern: "/^[0-9\-\+\s\(\)]{6,30}$/",
        match: true,
        message: "Le numero de téléphone n'est pas valid",
    )]
    #[ORM\Column(length: 255)]
    private ?string $phone = null;


    #[Assert\Length(
        max: 255,
        maxMessage: "le nom de La rue ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $street = null;

    #[Assert\Length(
        max: 255,
        maxMessage: "le nom de La ville ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[Assert\Length(
        min: 4,
        max: 10,
        minMessage: "le code postal doit faire minimum {{ limit }} caractères.",
        maxMessage: "le code postal doit faire maximum {{ limit }} caractères.",
    )]
    #[Assert\Regex(
        pattern: "/^[0-9]+$/",
        match: true,
        message: "Le code postal n'est pas valid",
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postalCode = null;

    #[Assert\NotBlank(message: "Le nom du pays est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le nom du pays  ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[Assert\Country(message : "Ce pays est inconnu ! ")]
    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWebsiteName(): ?string
    {
        return $this->websiteName;
    }

    public function setWebsiteName(? string $websiteName): static
    {
        $this->websiteName = $websiteName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(? string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postal_code): static
    {
        $this->postalCode = $postal_code;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(? string $websiteUrl): static
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }
}
