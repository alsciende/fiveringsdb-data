<?php

namespace App\Entity;

use Alsciende\SerializerBundle\Annotation\Skizzle;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of PackCard
 *
 * @ORM\Entity()
 * @ORM\Table(name="pack_cards")
 *
 * @Skizzle(break="pack_id")
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class PackCard
{
    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     *
     * @Skizzle\Field(type="integer")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", nullable=false)
     *
     * @Skizzle\Field(type="string")
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="illustrator", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $illustrator;

    /**
     * @var string|null
     *
     * @ORM\Column(name="flavor", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $flavor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_url", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    private $imageUrl;

    /**
     * @var \App\Entity\Card
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Card", fetch="EAGER")
     * @ORM\JoinColumn(name="card_id", referencedColumnName="id")
     *
     * @Skizzle\Field(type="association")
     */
    private $card;

    /**
     * @var \App\Entity\Pack
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Pack", fetch="EAGER")
     * @ORM\JoinColumn(name="pack_id", referencedColumnName="id")
     *
     * @Skizzle\Field(type="association")
     */
    private $pack;

    /**
     * @return int
     */
    public function getQuantity (): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getPosition (): string
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function getIllustrator (): string
    {
        return $this->illustrator;
    }

    /**
     * @return null|string
     */
    public function getFlavor (): ?string
    {
        return $this->flavor;
    }

    /**
     * @return null|string
     */
    public function getImageUrl (): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @return Card
     */
    public function getCard (): Card
    {
        return $this->card;
    }

    /**
     * @return Pack
     */
    public function getPack (): Pack
    {
        return $this->pack;
    }
}
