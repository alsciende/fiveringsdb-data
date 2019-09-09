<?php

namespace App\Entity;

use Alsciende\SerializerBundle\Annotation\Skizzle;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ClanRole
 *
 * @ORM\Entity()
 * @ORM\Table(name="clan_roles")
 *
 * @Skizzle()
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ClanRole
{
    /**
     * @var PrimaryRole
     *
     * @ORM\ManyToOne(targetEntity="Card")
     * @ORM\JoinColumn(name="primary_role_id", referencedColumnName="id", nullable=false)
     * 
     * @Skizzle\Field(type="association")
     */
    private $primaryRole;

    /**
     * @var SecondaryRole
     *
     * @ORM\ManyToOne(targetEntity="Card")
     * @ORM\JoinColumn(name="secondary_role_id", referencedColumnName="id", nullable=false)
     * 
     * @Skizzle\Field(type="association")
     */
    private $secondaryRole;

    /**
     * @var string
     *
     * @ORM\Column(name="clan", type="string", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @Skizzle\Field(type="string")
     */
    private $clan;

    function getPrimaryRole (): Card
    {
        return $this->primaryRole;
    }

    function setPrimaryRole (Card $card): self
    {
        $this->primaryRole = $card;

        return $this;
    }

    function getSecondaryRole (): Card
    {
        return $this->secondaryRole;
    }

    function setSecondaryRole (Card $card): self
    {
        $this->secondaryRole = $card;

        return $this;
    }

    public function getClan (): string
    {
        return $this->clan;
    }

    public function setClan (string $clan): self
    {
        $this->clan = $clan;

        return $this;
    }
}