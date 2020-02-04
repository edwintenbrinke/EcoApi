<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeInfoTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\StoreRepository")
 */
class Store
{
    use DatetimeInfoTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $external_id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"offers"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"offers"})
     */
    private $currency_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="stores", cascade={"persist"})
     * @Groups({"offers"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offer", mappedBy="store", cascade={"remove", "persist"})
     */
    private $offers;

    public function __construct($external_id, $name, $currency_name)
    {
        $this->external_id = $external_id;
        $this->name = $name;
        $this->currency_name = $currency_name;
        $this->offers = new ArrayCollection();
    }

    public static function createFromModData(array $data)
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['currency_name']
        );
    }

    public function updateFromModData(array $data)
    {
        $this->name = $data['name'];
        $this->currency_name = $data['currency_name'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCurrencyName(): ?string
    {
        return $this->currency_name;
    }

    public function setCurrencyName(string $currency_name): self
    {
        $this->currency_name = $currency_name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Offer[]
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setStore($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->contains($offer)) {
            $this->offers->removeElement($offer);
            // set the owning side to null (unless already changed)
            if ($offer->getStore() === $this) {
                $offer->setStore(null);
            }
        }

        return $this;
    }

    public function getExternalId(): ?int
    {
        return $this->external_id;
    }

    public function setExternalId(int $external_id): self
    {
        $this->external_id = $external_id;

        return $this;
    }
}
