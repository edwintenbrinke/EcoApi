<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeInfoTrait;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_process;

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

    public function getLastProcess(): ?\DateTimeInterface
    {
        return $this->last_process;
    }

    public function setLastProcess(?\DateTimeInterface $last_process): self
    {
        $this->last_process = $last_process;

        return $this;
    }
}
