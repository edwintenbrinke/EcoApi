<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeInfoTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(indexes={
 *     @ORM\Index(name="idx_username", columns={"name"}),
 * })
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    use DatetimeInfoTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"public"})
     */
    private $id;

    /**
     * @ORM\Column(type="guid")
     */
    private $guid;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Groups({"public"})
     */
    private $external_id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"public"})
     */
    private $slg_id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"public"})
     */
    private $steam_id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Groups({"public", "offers"})
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"public"})
     */
    private $total_play_time;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"public"})
     */
    private $last_online_time;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Groups({"public"})
     */
    private $online;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offer", mappedBy="user")
     */
    private $offers;

    public function __construct($external_id, $slg_id, $steam_id, $name, $total_play_time, $last_online_time, $online = false)
    {
        $this->guid = uuid_create(UUID_TYPE_RANDOM);
        $this->external_id = $external_id;
        $this->slg_id = $slg_id;
        $this->steam_id = $steam_id;
        $this->name = $name;
        $this->total_play_time = (int)$total_play_time;
        $this->last_online_time = (int)$last_online_time;
        $this->online = $online;
    }

    public static function createFromModData(array $data)
    {
        return new self(
            $data['id'],
            $data['slg_id'],
            $data['steam_id'],
            $data['name'],
            $data['total_play_time'],
            $data['last_online_time'],
            $data['online']
        );
    }

    public function updateFromModData(array $data)
    {
        $this->steam_id = $data['steam_id'];
        $this->name = $data['name'];
        $this->total_play_time = (int)$data['total_play_time'];
        $this->last_online_time = (int)$data['last_online_time'];
        $this->online = $data['online'];
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSlgId(): string
    {
        return $this->slg_id;
    }

    public function setSlgId(string $slg_id): self
    {
        $this->slg_id = $slg_id;

        return $this;
    }

    public function getSteamId(): ?string
    {
        return $this->steam_id;
    }

    public function setSteamId(?string $steam_id): self
    {
        $this->steam_id = $steam_id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTotalPlayTime(): ?int
    {
        return $this->total_play_time;
    }

    public function setTotalPlayTime(?int $total_play_time): self
    {
        $this->total_play_time = $total_play_time;

        return $this;
    }

    public function getLastOnlineTime(): ?int
    {
        return $this->last_online_time;
    }

    public function setLastOnlineTime(?int $last_online_time): self
    {
        $this->last_online_time = $last_online_time;

        return $this;
    }

    public function getOnline(): bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

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
}
