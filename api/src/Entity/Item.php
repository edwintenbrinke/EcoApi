<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"offers"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $external_id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"offers"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"offers"})
     */
    private $icon;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offer", mappedBy="item")
     */
    private $offers;

    public function __construct($external_id, $name, $icon = null)
    {
        $this->external_id = $external_id;
        $this->name = $name;
        $this->icon = $icon;
        $this->offers = new ArrayCollection();
    }

    public static function createFromOfferData(array $data)
    {
        return new self(
            $data['type_id'],
            $data['name']
        );
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): ?string
    {
        return $this->external_id;
    }

    public function setExternalId(string $external_id): self
    {
        $this->external_id = $external_id;

        return $this;
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

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
            $offer->setItem($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->contains($offer)) {
            $this->offers->removeElement($offer);
            // set the owning side to null (unless already changed)
            if ($offer->getItem() === $this) {
                $offer->setItem(null);
            }
        }

        return $this;
    }
}
