<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *** ORM\HasLifecycleCallbacks() needs to be added to the entity to make this work.
 *
 * Adds time fields to entities to see when what happened with lifecycle events.
 *
 * Class DatetimeInfoTrait
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
trait DatetimeInfoTrait
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Groups({"public"})
     */
    private $created_at;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Groups({"public"})
     */
    private $updated_at;

    /**
     * @ORM\PrePersist
     *
     * @return DatetimeInfoTrait
     *
     * @throws \Exception
     */
    public function prePersist()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();

        return $this;
    }

    /**
     * @ORM\PreUpdate
     *
     * @return DatetimeInfoTrait
     *
     * @throws \Exception
     */
    public function preUpdate()
    {
        $this->updated_at = new \DateTime();

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
