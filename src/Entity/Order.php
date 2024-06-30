<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{

    public const STATUS_PENDIND = "En cours";
    public const STATUS_PAYMENT_PROBLEM = "commande effectuée mais paiement réfusé";
    public const STATUS_PAYMENT_SUCCESSFULLY = "commande effectuée et paiement accépté";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $userEmail = null;

    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le prénom ne doit pas dépasser {{ limit }} caractères.',
    )]
    #[Assert\Regex(
        pattern: "/^[0-9a-zA-Z-_' áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]+$/i",
        match: true,
        message: 'Le prénom doit contenir uniquement des lettres, des chiffres le tiret du milieu de l\'undescore.',
    )]
    #[ORM\Column(length: 255)]
    private ?string $deliveryFirstName = null;

    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.',
    )]
    #[Assert\Regex(
        pattern: "/^[0-9a-zA-Z-_' áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]+$/i",
        match: true,
        message: 'Le nom doit contenir uniquement des lettres, des chiffres le tiret du milieu de l\'undescore.',
    )]
    #[ORM\Column(length: 255)]
    private ?string $deliveryLastName = null;

    #[Assert\Length(
        max: 180,
        maxMessage: "L'email ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[Assert\Email(
        message: "L'email {{ value }} n'est pas valide.",
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $deliveryEmail = null;

    #[Assert\NotBlank(message: "Le numero de téléphone est obligatoire.")]
    #[Assert\Length(
        min:6,
        max: 255,
        minMessage: 'Le numero de téléphone doit avoir au minimum {{ limit }} caractères.',
        maxMessage: 'Le numero de téléphone ne doit pas dépasser {{ limit }} caractères.',
    )]
    #[Assert\Regex(
        pattern: "/^[0-9\s\-\+\(\)]{6,255}$/",
        match: true,
        message: "Le numero de téléphone n'est pas valide.",
    )]
    #[ORM\Column(length: 255)]
    private ?string $deliveryPhone = null;

    #[Assert\NotBlank(message: "Le nom de la rue est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le nom de la rue ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[ORM\Column(length: 255)]
    private ?string $deliveryStreet = null;

    #[Assert\Regex(
        pattern: "/^\d{1,10}$/",
        match: true,
        message: "Le code postal doit être un nombre compris entre 1 et 10 chiffres."
    )]
    #[ORM\Column(length: 255)]
    private ?string $deliveryPostalCode = null;

    #[Assert\NotBlank(message: "La ville est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le nom de la ville ne doit pas dépasser {{ limit }} caractères.'
    )]
    #[ORM\Column(length: 255)]
    private ?string $deliveryCity = null;

    #[Assert\NotBlank(message: "Le pays est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le nom du pays ne doit pas dépasser {{ limit }} caractères.'
    )]
    #[Assert\Country(message: "Ce pays est inconnu.")]
    #[ORM\Column(length: 255)]
    private ?string $deliveryCountry = null;

    #[ORM\Column]
    private ?float $totalAmount = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $orderedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'theOrder', orphanRemoval: true)]
    private Collection $yes;

    #[Assert\NotBlank(message: "Le nom du livreur est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le nom du livreur ne doit pas dépasser {{ limit }} caractères.',
    )]
    #[ORM\Column(length: 255)]
    private ?string $carrierName = null;

    public function __construct()
    {
        $this->yes = new ArrayCollection();
    }

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

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(?string $userEmail): static
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getDeliveryFirstName(): ?string
    {
        return $this->deliveryFirstName;
    }

    public function setDeliveryFirstName(?string $deliveryFirstName): static
    {
        $this->deliveryFirstName = $deliveryFirstName;

        return $this;
    }

    public function getDeliveryLastName(): ?string
    {
        return $this->deliveryLastName;
    }

    public function setDeliveryLastName(?string $deliveryLastName): static
    {
        $this->deliveryLastName = $deliveryLastName;

        return $this;
    }

    public function getDeliveryEmail(): ?string
    {
        return $this->deliveryEmail;
    }

    public function setDeliveryEmail(?string $deliveryEmail): static
    {
        $this->deliveryEmail = $deliveryEmail;

        return $this;
    }

    public function getDeliveryPhone(): ?string
    {
        return $this->deliveryPhone;
    }

    public function setDeliveryPhone(?string $deliveryPhone): static
    {
        $this->deliveryPhone = $deliveryPhone;

        return $this;
    }

    public function getDeliveryStreet(): ?string
    {
        return $this->deliveryStreet;
    }

    public function setDeliveryStreet(?string $deliveryStreet): static
    {
        $this->deliveryStreet = $deliveryStreet;

        return $this;
    }

    public function getDeliveryPostalCode(): ?string
    {
        return $this->deliveryPostalCode;
    }

    public function setDeliveryPostalCode(?string $deliveryPostalCode): static
    {
        $this->deliveryPostalCode = $deliveryPostalCode;

        return $this;
    }

    public function getDeliveryCity
    (): ?string
    {
        return $this->deliveryCity;
    }

    public function setDeliveryCity(?string $deliveryCity): static
    {
        $this->deliveryCity = $deliveryCity;

        return $this;
    }

    public function getDeliveryCountry(): ?string
    {
        return $this->deliveryCountry;
    }

    public function setDeliveryCountry(?string $deliveryCountry): static
    {
        $this->deliveryCountry = $deliveryCountry;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(?float $totalAmount): static
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getOrderedAt(): ?\DateTimeImmutable
    {
        return $this->orderedAt;
    }

    public function setOrderedAt(?\DateTimeImmutable $orderedAt): static
    {
        $this->orderedAt = $orderedAt;

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

    /**
     * @return Collection<int, OrderItem>
     */
    public function getYes(): Collection
    {
        return $this->yes;
    }

    public function addYe(OrderItem $ye): static
    {
        if (!$this->yes->contains($ye)) {
            $this->yes->add($ye);
            $ye->setTheOrder($this);
        }

        return $this;
    }

    public function removeYe(OrderItem $ye): static
    {
        if ($this->yes->removeElement($ye)) {
            // set the owning side to null (unless already changed)
            if ($ye->getTheOrder() === $this) {
                $ye->setTheOrder(null);
            }
        }

        return $this;
    }

    public function getCarrierName(): ?string
    {
        return $this->carrierName;
    }

    public function setCarrierName(?string $carrierName): static
    {
        $this->carrierName = $carrierName;

        return $this;
    }
}
