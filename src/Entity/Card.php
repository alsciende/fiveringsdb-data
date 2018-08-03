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
    const TYPES = ['attachment', 'character', 'event', 'holding', 'province', 'role', 'stronghold'];
    const TYPE_ATTACHMENT = 'attachment';
    const TYPE_CHARACTER = 'character';
    const TYPE_EVENT = 'event';
    const TYPE_HOLDING = 'holding';
    const TYPE_PROVINCE = 'province';
    const TYPE_ROLE = 'role';
    const TYPE_STRONGHOLD = 'stronghold';

    const ELEMENTS = ['air', 'earth', 'fire', 'void', 'water'];
    const ELEMENT_AIR = 'air';
    const ELEMENT_EARTH = 'earth';
    const ELEMENT_FIRE = 'fire';
    const ELEMENT_VOID = 'void';
    const ELEMENT_WATER = 'water';

    const SIDES = ['conflict', 'dynasty', 'province', 'role'];
    const SIDE_CONFLICT = 'conflict';
    const SIDE_DYNASTY = 'dynasty';
    const SIDE_PROVINCE = 'province';
    const SIDE_ROLE = 'role';

    const CLANS = ['crab', 'crane', 'dragon', 'lion', 'phoenix', 'scorpion', 'unicorn'];
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
     * @var string
     *
     * @ORM\Column(name="name_canonical", type="string", length=255)
     */
    private $nameCanonical;

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
     * @ORM\Column(name="text_canonical", type="text", nullable=true)
     */
    private $textCanonical;

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
     * @var string|null
     *
     * @ORM\Column(name="military", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $military;

    /**
     * @var string|null
     *
     * @ORM\Column(name="political", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $political;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strength", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
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

    function __construct ()
    {
        $this->deckLimit = 3;
        $this->traits = [];
        $this->unicity = false;
    }

    public function setId (string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName (string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setNameCanonical (string $nameCanonical): self
    {
        $this->nameCanonical = $nameCanonical;

        return $this;
    }

    public function setCost (int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function setText (string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function setTextCanonical (string $textCanonical): self
    {
        $this->textCanonical = $textCanonical;

        return $this;
    }

    public function setType (string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setClan (string $clan): self
    {
        $this->clan = $clan;

        return $this;
    }

    public function setElement (string $element = null): self
    {
        $this->element = $element;

        return $this;
    }

    public function setUnicity (bool $unicity): self
    {
        $this->unicity = $unicity;

        return $this;
    }

    public function setSide (string $side): self
    {
        $this->side = $side;

        return $this;
    }

    public function setTraits (array $traits): self
    {
        $this->traits = $traits;

        return $this;
    }

    public function setMilitary (string $military): self
    {
        $this->military = $military;

        return $this;
    }

    public function setPolitical (string $political): self
    {
        $this->political = $political;

        return $this;
    }

    public function setStrength (string $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function setMilitaryBonus (string $militaryBonus): self
    {
        $this->militaryBonus = $militaryBonus;

        return $this;
    }

    public function setPoliticalBonus (string $politicalBonus): self
    {
        $this->politicalBonus = $politicalBonus;

        return $this;
    }

    public function setStrengthBonus (string $strengthBonus): self
    {
        $this->strengthBonus = $strengthBonus;

        return $this;
    }

    public function setGlory (int $glory): self
    {
        $this->glory = $glory;

        return $this;
    }

    public function setHonor (int $honor): self
    {
        $this->honor = $honor;

        return $this;
    }

    public function setFate (int $fate): self
    {
        $this->fate = $fate;

        return $this;
    }

    public function setInfluencePool (int $influencePool): self
    {
        $this->influencePool = $influencePool;

        return $this;
    }

    public function setInfluenceCost (int $influenceCost = null): self
    {
        $this->influenceCost = $influenceCost;

        return $this;
    }

    public function getId (): string
    {
        return $this->id;
    }

    public function getName (): string
    {
        return $this->name;
    }

    public function getNameCanonical (): ?string
    {
        return $this->nameCanonical;
    }

    public function getCost (): ?int
    {
        return $this->cost;
    }

    public function getText (): ?string
    {
        return $this->text;
    }

    public function getTextCanonical (): ?string
    {
        return $this->textCanonical;
    }

    public function getType (): string
    {
        return $this->type;
    }

    public function getClan (): string
    {
        return $this->clan;
    }

    public function getElement (): ?string
    {
        return $this->element;
    }

    public function isUnicity (): bool
    {
        return $this->unicity;
    }

    public function getSide (): string
    {
        return $this->side;
    }

    public function getTraits (): array
    {
        return $this->traits;
    }

    public function hasTrait ($trait): bool
    {
        return in_array($trait, $this->traits);
    }

    public function getMilitary (): ?string
    {
        return $this->military;
    }

    public function getPolitical (): ?string
    {
        return $this->political;
    }

    public function getStrength (): ?string
    {
        return $this->strength;
    }

    public function getMilitaryBonus (): ?string
    {
        return $this->militaryBonus;
    }

    public function getPoliticalBonus (): ?string
    {
        return $this->politicalBonus;
    }

    public function getStrengthBonus (): ?string
    {
        return $this->strengthBonus;
    }

    public function getGlory (): ?int
    {
        return $this->glory;
    }

    public function getHonor (): ?int
    {
        return $this->honor;
    }

    public function getFate (): ?int
    {
        return $this->fate;
    }

    public function getInfluencePool (): ?int
    {
        return $this->influencePool;
    }

    public function getInfluenceCost (): ?int
    {
        return $this->influenceCost;
    }

    public function setDeckLimit (int $deckLimit): self
    {
        $this->deckLimit = $deckLimit;

        return $this;
    }

    public function getDeckLimit (): ?int
    {
        return $this->deckLimit;
    }

    public function getRoleRestriction (): ?string
    {
        return $this->roleRestriction;
    }

    public function setRoleRestriction (string $roleRestriction = null): self
    {
        $this->roleRestriction = $roleRestriction;

        return $this;
    }
}
