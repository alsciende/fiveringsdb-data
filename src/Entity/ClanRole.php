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
     * @var Card
     *
     * @ORM\ManyToOne(targetEntity="Card")
     * @ORM\JoinColumn(name="card_id", referencedColumnName="id")
     *
     * @Skizzle\Field(type="association")
     */
    private $card;

    /**
     * @var string
     *
     * @ORM\Column(name="clan", type="string", nullable=false, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @Skizzle\Field(type="string")
     */
    private $clan;

    /**
     * @return Card
     */
    public function getCard (): Card
    {
        return $this->card;
    }

    /**
     * @return string
     */
    public function getClan (): string
    {
        return $this->clan;
    }

    /**
     * @param Card $card
     *
     * @return self
     */
    public function setCard (Card $card): self
    {
        $this->card = $card;

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
}