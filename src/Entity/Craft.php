<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CraftRepository")
 */
class Craft
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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


    public function __construct($time_seconds, $item_type)
    {
        $this->time_seconds = $time_seconds;
        $this->item_type = $item_type;
    }

    public static function createFromEcoData(User $user, array $data)
    {
        return new self(
            $data['TimeSeconds'],
            $data['ItemTypeName']
        );
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
