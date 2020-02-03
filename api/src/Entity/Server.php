<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeInfoTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\ServerRepository")
 */
class Server
{
    // TODO make this configurable
    public const SERVER_NAME = 'MaistasHaven';

    use DatetimeInfoTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"public"})
     */
    private $id;

    /**
     * @ORM\Column(type="guid", nullable=true)
     * @Groups({"public"})
     */
    private $external_id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"public"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"public"})
     */
    private $export_last_process;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"public"})
     */
    private $version;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"public"})
     */
    private $time_left;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"public"})
     */
    private $time_since_start;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"public"})
     */
    private $online_players;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"public"})
     */
    private $total_players;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"public"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"public"})
     */
    private $detailed_description;

    public function updateFromMod(array $data)
    {
        $this->external_id = $data['id'];
        $this->version = $data['version'];
        $this->time_left = $data['time_left'];
        $this->time_since_start = $data['time_since_start'];
        $this->description = $data['description'];
        $this->detailed_description = $data['detailed_description'];
        $this->online_players = $data['online_players'];
        $this->total_players = $data['total_players'];
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return mixed
     */
    public function getExportLastProcess()
    {
        return $this->export_last_process;
    }

    /**
     * @param mixed $export_last_process
     */
    public function setExportLastProcess($export_last_process): void
    {
        $this->export_last_process = $export_last_process;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getTimeLeft(): ?int
    {
        return $this->time_left;
    }

    public function setTimeLeft(?int $time_left): self
    {
        $this->time_left = $time_left;

        return $this;
    }

    public function getTimeSinceStart(): ?int
    {
        return $this->time_since_start;
    }

    public function setTimeSinceStart(?int $time_since_start): self
    {
        $this->time_since_start = $time_since_start;

        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->external_id;
    }

    public function setExternalId(?string $external_id): self
    {
        $this->external_id = $external_id;

        return $this;
    }

    public function getOnlinePlayers(): ?int
    {
        return $this->online_players;
    }

    public function setOnlinePlayers(int $online_players): self
    {
        $this->online_players = $online_players;

        return $this;
    }

    public function getTotalPlayers(): ?int
    {
        return $this->total_players;
    }

    public function setTotalPlayers(int $total_players): self
    {
        $this->total_players = $total_players;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDetailedDescription(): ?string
    {
        return $this->detailed_description;
    }

    public function setDetailedDescription(?string $detailed_description): self
    {
        $this->detailed_description = $detailed_description;

        return $this;
    }
}
