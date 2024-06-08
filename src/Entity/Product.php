<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Vich\Uploadable]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?User $user = null;

    #[Assert\NotBlank(message : "Veuillez selectionner au moins une catégorie.")]
    #[Assert\Type(
        type: Category::class,
        message: "Cette catégorie n'est pas valide.",)]
    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    #[Assert\NotBlank(message : "Le code est obligatoire")]
    #[Assert\Length(
        max: 50,
        maxMessage: 'Le code produit ne doit pas dépasser {{ limit }} caractères',
    )]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $code = null;

    #[Assert\NotBlank(message : "Le nom du produit est obligatoire.")]
    #[Assert\Length(
        max: 50,
        maxMessage: 'Le nom du produit ne doit pas dépasser {{ limit }} caractères',
    )]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Gedmo\Slug(fields: ['name'])]
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[Assert\NotBlank(message : "La déscription est obligatoire.")]
    #[Assert\Length(
        max: 1000,
        maxMessage: 'La déscription ne doit pas dépasser {{ limit }} caractères',
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Assert\Length(
        max: 255,
        maxMessage: 'La marque ne doit pas dépasser {{ limit }} caractères',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brand = null;

    #[Assert\Positive(message : "Le prix de vente doit être un nombre positif.")]
    #[Assert\Regex (
        pattern: "/^\d+(\.\d{1,2})?$/",
        message: "Le prix de vente doit être un entier ou un nombre décimal avec au plus deux décimales."
    )]
    #[Assert\Range(
        min: 0.1,
        max: 999999,
        notInRangeMessage: 'Le prix de vente doit être compris entre {{ mini }} euros {{ max }} euros',
    )]
    #[ORM\Column]
    private ?float $sellingPrice = null;

    #[Assert\Type(type : "integer", message : "La quantité doit être un entier.")]
    #[Assert\GreaterThanOrEqual(value: 0, message : "La quantité doit être un nombre positif.")]
    #[ORM\Column]
    private ?int $quantity = null;

    #[Assert\Type(type : "bool", message : "Le champ nouvel arrivage doit être de type booléen.")]
    #[ORM\Column]
    private ?bool $isNewArrival = null;

    #[Assert\Type(type : "bool", message : "Le champ meilleure vente doit être de type booléen.")]
    #[ORM\Column]
    private ?bool $isBetterSeller = null;

    #[Assert\File(
        maxSize: '5000k',
        extensions: ['jpg', 'jpeg', 'png' ,'web'],
        maxSizeMessage:"La taille del'image ne doit pas dépasser 2MO",
        extensionsMessage: 'Seuls les formats jpg, jpeg, png ,web sont autorisés',
    )]
    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getSellingPrice(): ?float
    {
        return $this->sellingPrice;
    }

    public function setSellingPrice(float $sellingPrice): static
    {
        $this->sellingPrice = $sellingPrice;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getIsNewArrival(): ?bool
    {
        return $this->isNewArrival;
    }

    public function setIsNewArrival(bool $isNewArrival): static
    {
        $this->isNewArrival = $isNewArrival;

        return $this;
    }

    public function getIsBetterSeller(): ?bool
    {
        return $this->isBetterSeller;
    }

    public function setIsBetterSeller(bool $isBetterSeller): static
    {
        $this->isBetterSeller = $isBetterSeller;

        return $this;
    }

    
     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(? string $image): static
    {
        $this->image = $image;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
