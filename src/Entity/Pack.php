<?php

namespace App\Entity;

use Alsciende\SerializerBundle\Annotation\Skizzle;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pack
 *
 * @ORM\Entity()
 * @ORM\Table(name="packs")
 *
 * @Skizzle()
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Pack
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
     * @var \DateTime
     *
     * @ORM\Column(name="released_at", type="date", nullable=true)
     *
     * @Skizzle\Field(type="date")
     */
    private $releasedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="ffg_id", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $ffgId;

    /**
     * @var Cycle
     *
     * @ORM\ManyToOne(targetEntity="Cycle", fetch="EAGER")
     * @ORM\JoinColumn(name="cycle_id", referencedColumnName="id", nullable=false)
     *
     * @Skizzle\Field(type="association")
     */
    private $cycle;

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
     * @return \DateTime
     */
    public function getReleasedAt (): \DateTime
    {
        return $this->releasedAt;
    }

    /**
     * @return string
     */
    public function getFfgId (): string
    {
        return $this->ffgId;
    }

    /**
     * @return Cycle
     */
    public function getCycle (): Cycle
    {
        return $this->cycle;
    }
}
