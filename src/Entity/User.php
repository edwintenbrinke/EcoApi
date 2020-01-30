<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="guid", nullable=true)
     */
    private $auth_id;

    public function __construct($username, $auth_id)
    {
        $this->username = $username;
        $this->auth_id = $auth_id;
    }

    public static function createFromItem(array $item)
    {
        return new self(
            $item['Username'],
            isset($item['AuthId']) ? $item['AuthId'] : null
        );
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
