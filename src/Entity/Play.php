<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayRepository")
 */
class Play
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
     * @ORM\Column(type="float")
     */
    private $value;

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

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }
}
