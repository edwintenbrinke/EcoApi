<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeInfoTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
{
    use DatetimeInfoTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"offers"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"offers"})
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"offers"})
     */
    private $buying;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"offers"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"offers"})
     */
    private $max_num_wanted;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Store", inversedBy="offers", cascade={"persist"})
     * @Groups({"offers"})
     */
    private $store;

    public function __construct($price, $buying, $name, $max_num_wanted)
    {
        $this->price = $price;
        $this->buying = $buying;
        $this->name = $name;
        $this->max_num_wanted = $max_num_wanted;
    }

    public static function createFromModData(array $data)
    {
        return new self(
            $data['price'],
            $data['buying'],
            $data['name'],
            $data['max_num_wanted']
        );
    }

    public function updateFromModData(array $data)
    {
        $this->price = $data['price'];
        $this->buying = $data['buying'];
        $this->name = $data['name'];
        $this->max_num_wanted = $data['max_num_wanted'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBuying(): ?bool
    {
        return $this->buying;
    }

    public function setBuying(bool $buying): self
    {
        $this->buying = $buying;

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

    public function getMaxNumWanted(): ?int
    {
        return $this->max_num_wanted;
    }

    public function setMaxNumWanted(int $max_num_wanted): self
    {
        $this->max_num_wanted = $max_num_wanted;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }
}
