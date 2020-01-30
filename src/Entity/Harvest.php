<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeInfoTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\HarvestRepository")
 */
class Harvest
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
     * @ORM\Column(type="integer")
     */
    private $time_seconds;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $species_name;

    public function __construct($_id, $username, $time_seconds, $species_name)
    {
        $this->_id = $_id;
        $this->username = $username;
        $this->time_seconds = $time_seconds;
        $this->species_name = $species_name;
    }

    public static function createFromEcoData(array $data)
    {
        return new self(
            $data['_id'],
            $data['Username'],
            $data['TimeSeconds'],
            $data['SpeciesName']
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getSpeciesName(): ?string
    {
        return $this->species_name;
    }

    public function setSpeciesName(string $species_name): self
    {
        $this->species_name = $species_name;

        return $this;
    }

    public function setId(int $_id): self
    {
        $this->_id = $_id;

        return $this;
    }
}
