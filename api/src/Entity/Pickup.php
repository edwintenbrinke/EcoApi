<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeInfoTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\PickupRepository")
 */
class Pickup
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
     * @ORM\Column(type="integer")
     * @Groups({"public"})
     */
    private $external_id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"public"})
     */
    private $username;

    /**
     * @ORM\Column(type="guid", nullable=true)
     * @Groups({"public"})
     */
    private $auth_id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"public"})
     */
    private $time_seconds;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"public"})
     */
    private $item_type;

    public function __construct($_id, $username, $auth_id, $time_seconds, $item_type)
    {
        $this->external_id = $_id;
        $this->username = $username;
        $this->auth_id = $auth_id;
        $this->time_seconds = $time_seconds;
        $this->item_type = $item_type;
    }

    public static function createFromEcoData(array $data)
    {
        return new self(
            $data['_id'],
            $data['Username'],
            isset($data['AuthId']) ? $data['AuthId'] : null,
            $data['TimeSeconds'],
            $data['ItemTypeName']
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): ?int
    {
        return $this->external_id;
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

    public function getAuthId(): ?string
    {
        return $this->auth_id;
    }

    public function setAuthId(string $auth_id): self
    {
        $this->auth_id = $auth_id;

        return $this;
    }

    public function getTimeSeconds(): ?int
    {
        return $this->time_seconds;
    }

    public function setTimeSeconds(int $time_seconds): self
    {
        $this->time_seconds = $time_seconds;

        return $this;
    }

    public function getItemType(): ?string
    {
        return $this->item_type;
    }

    public function setItemType(string $item_type): self
    {
        $this->item_type = $item_type;

        return $this;
    }

    public function setId(int $_id): self
    {
        $this->_id = $_id;

        return $this;
    }
}
