<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlaceRepository")
 */
class Place
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
     * @ORM\Column(type="string", length=255)
     */
    private $item_type;


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

    public function getItemType(): ?string
    {
        return $this->item_type;
    }

    public function setItemType(string $item_type): self
    {
        $this->item_type = $item_type;

        return $this;
    }
}
