<?php

namespace App\Entity;

use Alsciende\SerializerBundle\Annotation\Skizzle;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cycle
 *
 * @ORM\Entity()
 * @ORM\Table(name="cycles")
 *
 * @Skizzle()
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Cycle
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=255, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @Skizzle\Field(type="string")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     *
     * @Skizzle\Field(type="integer")
     */
    private $position;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer", nullable=true)
     *
     * @Skizzle\Field(type="integer")
     */
    private $size;

    /**
     * @return string
     */
    public function getId (): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName (): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPosition (): int
    {
        return $this->position;
    }

    /**
     * @return int
     */
    public function getSize (): int
    {
        return $this->size;
    }

    /**
     * @param string $id
     *
     * @return self
     */
    public function setId (string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName (string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $position
     *
     * @return self
     */
    public function setPosition (int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @param int $size
     *
     * @return self
     */
    public function setSize (int $size): self
    {
        $this->size = $size;

        return $this;
    }
}
