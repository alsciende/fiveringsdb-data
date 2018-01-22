<?php

namespace App\Entity;

use Alsciende\SerializerBundle\Annotation\Skizzle;
use Doctrine\ORM\Mapping as ORM;

/**
 * Card
 *
 * @ORM\Entity()
 * @ORM\Table(name="cards")
 *
 * @Skizzle(break="id")
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Card
{
    const TYPE_ATTACHMENT = 'attachment';
    const TYPE_CHARACTER = 'character';
    const TYPE_EVENT = 'event';
    const TYPE_HOLDING = 'holding';
    const TYPE_PROVINCE = 'province';
    const TYPE_ROLE = 'role';
    const TYPE_STRONGHOLD = 'stronghold';

    const ELEMENT_AIR = 'air';
    const ELEMENT_EARTH = 'earth';
    const ELEMENT_FIRE = 'fire';
    const ELEMENT_VOID = 'void';
    const ELEMENT_WATER = 'water';

    const SIDE_CONFLICT = 'conflict';
    const SIDE_DYNASTY = 'dynasty';
    const SIDE_PROVINCE = 'province';
    const SIDE_ROLE = 'role';

    const CLAN_CRAB = 'crab';
    const CLAN_CRANE = 'crane';
    const CLAN_DRAGON = 'dragon';
    const CLAN_LION = 'lion';
    const CLAN_NEUTRAL = 'neutral';
    const CLAN_PHOENIX = 'phoenix';
    const CLAN_SCORPION = 'scorpion';
    const CLAN_UNICORN = 'unicorn';

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
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Skizzle\Field(type="string")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="cost", type="integer", nullable=true)
     *
     * @Skizzle\Field(type="integer")
     */
    private $cost;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="text", nullable=false)
     *
     * @Skizzle\Field(type="string")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="clan", type="text", nullable=false)
     *
     * @Skizzle\Field(type="string")
     */
    private $clan;

    /**
     * @var string|null
     *
     * @ORM\Column(name="element", type="text", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $element;

    /**
     * @var boolean
     *
     * @ORM\Column(name="unicity", type="boolean", nullable=false)
     *
     * @Skizzle\Field(type="boolean")
     */
    private $unicity;

    /**
     * @var string
     *
     * @ORM\Column(name="side", type="string", nullable=false)
     *
     * @Skizzle\Field(type="string")
     */
    private $side;

    /**
     * @var array
     *
     * @ORM\Column(name="traits", type="simple_array", nullable=true)
     *
     * @Skizzle\Field(type="array")
     */
    private $traits;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="military", type="smallint", nullable=true)
     *
     * @Skizzle\Field(type="integer")
     */
    private $military;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="political", type="smallint", nullable=true)
     *
     * @Skizzle\Field(type="integer")
     */
    private $political;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="strength", type="smallint", nullable=true)
     *
     * @Skizzle\Field(type="integer")
     */
    private $strength;

    /**
     * @var string|null
     *
     * @ORM\Column(name="military_bonus", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $militaryBonus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="political_bonus", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $politicalBonus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strength_bonus", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $strengthBonus;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="glory", type="smallint", nullable=true)
     *
     * @Skizzle\Field(type="integer")
     */
    private $glory;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="honor", type="smallint", nullable=true)
     *
     * @Skizzle\Field(type="integer")
     */
    private $honor;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="fate", type="smallint", nullable=true)
     *
     * @Skizzle\Field(type="integer")
     */
    private $fate;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="influence_pool", type="smallint", nullable=true)
     *
     * @Skizzle\Field(type="integer")
     */
    private $influencePool;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="influence_cost", type="smallint", nullable=true)
     *
     * @Skizzle\Field(type="integer")
     */
    private $influenceCost;

    /**
     * @var integer
     *
     * @ORM\Column(name="deck_limit", type="smallint", nullable=false)
     *
     * @Skizzle\Field(type="integer")
     */
    private $deckLimit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="role_restriction", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $roleRestriction;

    public function __construct ()
    {
        $this->deckLimit = 3;
        $this->traits = [];
        $this->unicity = false;
    }

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
    public function getCost (): int
    {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function getText (): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getType (): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getClan (): string
    {
        return $this->clan;
    }

    /**
     * @return null|string
     */
    public function getElement (): ?string
    {
        return $this->element;
    }

    /**
     * @return bool
     */
    public function isUnicity (): bool
    {
        return $this->unicity;
    }

    /**
     * @return string
     */
    public function getSide (): string
    {
        return $this->side;
    }

    /**
     * @return array
     */
    public function getTraits (): array
    {
        return $this->traits;
    }

    /**
     * @return int|null
     */
    public function getMilitary (): ?int
    {
        return $this->military;
    }

    /**
     * @return int|null
     */
    public function getPolitical (): ?int
    {
        return $this->political;
    }

    /**
     * @return int|null
     */
    public function getStrength (): ?int
    {
        return $this->strength;
    }

    /**
     * @return null|string
     */
    public function getMilitaryBonus (): ?string
    {
        return $this->militaryBonus;
    }

    /**
     * @return null|string
     */
    public function getPoliticalBonus (): ?string
    {
        return $this->politicalBonus;
    }

    /**
     * @return null|string
     */
    public function getStrengthBonus (): ?string
    {
        return $this->strengthBonus;
    }

    /**
     * @return int|null
     */
    public function getGlory (): ?int
    {
        return $this->glory;
    }

    /**
     * @return int|null
     */
    public function getHonor (): ?int
    {
        return $this->honor;
    }

    /**
     * @return int|null
     */
    public function getFate (): ?int
    {
        return $this->fate;
    }

    /**
     * @return int|null
     */
    public function getInfluencePool (): ?int
    {
        return $this->influencePool;
    }

    /**
     * @return int|null
     */
    public function getInfluenceCost (): ?int
    {
        return $this->influenceCost;
    }

    /**
     * @return int
     */
    public function getDeckLimit (): int
    {
        return $this->deckLimit;
    }

    /**
     * @return null|string
     */
    public function getRoleRestriction (): ?string
    {
        return $this->roleRestriction;
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
     * @param int $cost
     *
     * @return self
     */
    public function setCost (int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @param string $text
     *
     * @return self
     */
    public function setText (string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function setType (string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $clan
     *
     * @return self
     */
    public function setClan (string $clan): self
    {
        $this->clan = $clan;

        return $this;
    }

    /**
     * @param null|string $element
     *
     * @return self
     */
    public function setElement (?string $element): self
    {
        $this->element = $element;

        return $this;
    }

    /**
     * @param bool $unicity
     *
     * @return self
     */
    public function setUnicity (bool $unicity): self
    {
        $this->unicity = $unicity;

        return $this;
    }

    /**
     * @param string $side
     *
     * @return self
     */
    public function setSide (string $side): self
    {
        $this->side = $side;

        return $this;
    }

    /**
     * @param array $traits
     *
     * @return self
     */
    public function setTraits (array $traits): self
    {
        $this->traits = $traits;

        return $this;
    }

    /**
     * @param int|null $military
     *
     * @return self
     */
    public function setMilitary (?int $military): self
    {
        $this->military = $military;

        return $this;
    }

    /**
     * @param int|null $political
     *
     * @return self
     */
    public function setPolitical (?int $political): self
    {
        $this->political = $political;

        return $this;
    }

    /**
     * @param int|null $strength
     *
     * @return self
     */
    public function setStrength (?int $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * @param null|string $militaryBonus
     *
     * @return self
     */
    public function setMilitaryBonus (?string $militaryBonus): self
    {
        $this->militaryBonus = $militaryBonus;

        return $this;
    }

    /**
     * @param null|string $politicalBonus
     *
     * @return self
     */
    public function setPoliticalBonus (?string $politicalBonus): self
    {
        $this->politicalBonus = $politicalBonus;

        return $this;
    }

    /**
     * @param null|string $strengthBonus
     *
     * @return self
     */
    public function setStrengthBonus (?string $strengthBonus): self
    {
        $this->strengthBonus = $strengthBonus;

        return $this;
    }

    /**
     * @param int|null $glory
     *
     * @return self
     */
    public function setGlory (?int $glory): self
    {
        $this->glory = $glory;

        return $this;
    }

    /**
     * @param int|null $honor
     *
     * @return self
     */
    public function setHonor (?int $honor): self
    {
        $this->honor = $honor;

        return $this;
    }

    /**
     * @param int|null $fate
     *
     * @return self
     */
    public function setFate (?int $fate): self
    {
        $this->fate = $fate;

        return $this;
    }

    /**
     * @param int|null $influencePool
     *
     * @return self
     */
    public function setInfluencePool (?int $influencePool): self
    {
        $this->influencePool = $influencePool;

        return $this;
    }

    /**
     * @param int|null $influenceCost
     *
     * @return self
     */
    public function setInfluenceCost (?int $influenceCost): self
    {
        $this->influenceCost = $influenceCost;

        return $this;
    }

    /**
     * @param int $deckLimit
     *
     * @return self
     */
    public function setDeckLimit (int $deckLimit): self
    {
        $this->deckLimit = $deckLimit;

        return $this;
    }

    /**
     * @param null|string $roleRestriction
     *
     * @return self
     */
    public function setRoleRestriction (?string $roleRestriction): self
    {
        $this->roleRestriction = $roleRestriction;

        return $this;
    }
}
