<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeInfoTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\BuyRepository")
 */
class Buy
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
    private $_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="guid")
     */
    private $auth_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $time_seconds;

    /**
     * @ORM\Column(type="guid")
     */
    private $world_object_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $item_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $world_object_type;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    public function __construct($_id, $username, $auth_id, $time_seconds, $item_type, $world_object_id, $world_object_type, $amount = 0)
    {
        $this->_id = $_id;
        $this->username = $username;
        $this->auth_id = $auth_id;
        $this->time_seconds = $time_seconds;
        $this->item_type = $item_type;
        $this->world_object_id = $world_object_id;
        $this->world_object_type = $world_object_type;
        $this->amount = $amount;
    }

    public static function createFromEcoData(array $data)
    {
        return new self(
            $data['_id'],
            $data['Username'],
            $data['AuthId'],
            $data['TimeSeconds'],
            $data['ItemTypeName'],
            $data['WorldObjectId'],
            $data['WorldObjectTypeName'],
            $data['Amount']
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): ?int
    {
        return $this->_id;
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

    public function getWorldObjectId(): ?string
    {
        return $this->world_object_id;
    }

    public function setWorldObjectId(string $world_object_id): self
    {
        $this->world_object_id = $world_object_id;

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

    public function getWorldObjectType(): ?string
    {
        return $this->world_object_type;
    }

    public function setWorldObjectType(string $world_object_type): self
    {
        $this->world_object_type = $world_object_type;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
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

    public function setId(int $_id): self
    {
        $this->_id = $_id;

        return $this;
    }
}
