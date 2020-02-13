<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeInfoTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(indexes={
 *     @ORM\Index(name="idx_item_name", columns={"name", "user_name"}),
 * })
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
     * @ORM\Column(type="guid")
     */
    private $guid;

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
     * @ORM\Column(type="string")
     */
    private $store_id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"offers"})
     */
    private $store_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"offers"})
     */
    private $currency_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"offers"})
     */
    private $user_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="offers")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"offers"})
     */
    private $item;

    public function __construct($price, $buying, $name, $max_num_wanted, $store_id, $store_name, $currency_name, $user_name)
    {
        $this->guid = uuid_create(UUID_TYPE_RANDOM);
        $this->price = $price;
        $this->buying = $buying;
        $this->name = $name;
        $this->max_num_wanted = $max_num_wanted;
        $this->store_id = $store_id;
        $this->store_name = $store_name;
        $this->currency_name = $currency_name;
        $this->user_name = $user_name;
    }

    public static function createFromModData(array $data)
    {
        return new self(
            $data['price'],
            $data['buying'],
            $data['name'],
            $data['max_num_wanted'],
            $data['store_id'],
            $data['store_name'],
            $data['currency_name'],
            $data['user_name']
        );
    }

    public function updateFromModData(array $data)
    {
        $this->price = $data['price'];
        $this->name = $data['name'];
        $this->max_num_wanted = $data['max_num_wanted'];
        $this->store_name = $data['store_name'];
        $this->currency_name = $data['currency_name'];
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

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->store_id;
    }

    /**
     * @param mixed $store_id
     */
    public function setStoreId($store_id): void
    {
        $this->store_id = $store_id;
    }

    public function getStoreName(): ?string
    {
        return $this->store_name;
    }

    public function setStoreName(string $shop_name): self
    {
        $this->store_name = $shop_name;

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

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): self
    {
        $this->user_name = $user_name;

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

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function setGuid(string $guid): self
    {
        $this->guid = $guid;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }
}
