<?php

namespace App\Model;

class Card
{
    private string $id;

    private string $name;

    private ?int $cost = null;

    private string $text;

    private string $type;

    private string $clan;

    /**
     * @var string[]
     */
    private array $elements;

    private bool $isUnique;

    private string $side;

    /**
     * @var string[]
     */
    private array $traits;

    private ?string $military = null;

    private ?string $political = null;

    private ?string $strength = null;

    private ?string $militaryBonus = null;

    private ?string $politicalBonus = null;

    private ?string $strengthBonus = null;

    private ?int $glory = null;

    private ?int $honor = null;

    private ?int $fate = null;

    private ?int $influencePool = null;

    private ?int $influenceCost = null;

    private int $deckLimit;

    private ?string $roleRestriction = null;

    function __construct()
    {
        $this->deckLimit = 3;
        $this->elements = [];
        $this->traits = [];
        $this->isUnique = false;
    }

    public function hasTrait(string $trait): bool
    {
        return in_array($trait, $this->traits);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(?int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getClan(): string
    {
        return $this->clan;
    }

    public function setClan(string $clan): self
    {
        $this->clan = $clan;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * @param string[] $elements
     */
    public function setElements(array $elements): void
    {
        $this->elements = $elements;
    }

    public function getIsUnique(): bool
    {
        return $this->isUnique;
    }

    public function setIsUnique(bool $isUnique): self
    {
        $this->isUnique = $isUnique;

        return $this;
    }

    public function getSide(): string
    {
        return $this->side;
    }

    public function setSide(string $side): self
    {
        $this->side = $side;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getTraits(): array
    {
        return $this->traits;
    }

    /**
     * @param string[] $traits
     */
    public function setTraits(array $traits): self
    {
        $this->traits = $traits;

        return $this;
    }

    public function getMilitary(): ?string
    {
        return $this->military;
    }

    public function setMilitary(?string $military): self
    {
        $this->military = $military;

        return $this;
    }

    public function getPolitical(): ?string
    {
        return $this->political;
    }

    public function setPolitical(?string $political): self
    {
        $this->political = $political;

        return $this;
    }

    public function getStrength(): ?string
    {
        return $this->strength;
    }

    public function setStrength(?string $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function getMilitaryBonus(): ?string
    {
        return $this->militaryBonus;
    }

    public function setMilitaryBonus(?string $militaryBonus): self
    {
        $this->militaryBonus = $militaryBonus;

        return $this;
    }

    public function getPoliticalBonus(): ?string
    {
        return $this->politicalBonus;
    }

    public function setPoliticalBonus(?string $politicalBonus): self
    {
        $this->politicalBonus = $politicalBonus;

        return $this;
    }

    public function getStrengthBonus(): ?string
    {
        return $this->strengthBonus;
    }

    public function setStrengthBonus(?string $strengthBonus): self
    {
        $this->strengthBonus = $strengthBonus;

        return $this;
    }

    public function getGlory(): ?int
    {
        return $this->glory;
    }

    public function setGlory(?int $glory): self
    {
        $this->glory = $glory;

        return $this;
    }

    public function getHonor(): ?int
    {
        return $this->honor;
    }

    public function setHonor(?int $honor): self
    {
        $this->honor = $honor;

        return $this;
    }

    public function getFate(): ?int
    {
        return $this->fate;
    }

    public function setFate(?int $fate): self
    {
        $this->fate = $fate;

        return $this;
    }

    public function getInfluencePool(): ?int
    {
        return $this->influencePool;
    }

    public function setInfluencePool(?int $influencePool): self
    {
        $this->influencePool = $influencePool;

        return $this;
    }

    public function getInfluenceCost(): ?int
    {
        return $this->influenceCost;
    }

    public function setInfluenceCost(?int $influenceCost): self
    {
        $this->influenceCost = $influenceCost;

        return $this;
    }

    public function getDeckLimit(): int
    {
        return $this->deckLimit;
    }

    public function setDeckLimit(int $deckLimit): self
    {
        $this->deckLimit = $deckLimit;

        return $this;
    }

    public function getRoleRestriction(): ?string
    {
        return $this->roleRestriction;
    }

    public function setRoleRestriction(?string $roleRestriction): self
    {
        $this->roleRestriction = $roleRestriction;

        return $this;
    }
}
