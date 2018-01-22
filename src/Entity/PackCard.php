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
    public $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", nullable=false)
     *
     * @Skizzle\Field(type="string")
     */
    public $position;

    /**
     * @var string
     *
     * @ORM\Column(name="illustrator", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    public $illustrator;

    /**
     * @var string|null
     *
     * @ORM\Column(name="flavor", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    public $flavor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_url", type="string", nullable=true)
     *
     * @Skizzle\Field(type="string")
     */
    public $imageUrl;

    /**
     * @var \App\Entity\Card
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Card", fetch="EAGER")
     * @ORM\JoinColumn(name="card_id", referencedColumnName="id")
     *
     * @Skizzle\Field(type="association")
     */
    public $card;

    /**
     * @var \App\Entity\Pack
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Pack", fetch="EAGER")
     * @ORM\JoinColumn(name="pack_id", referencedColumnName="id")
     *
     * @Skizzle\Field(type="association")
     */
    public $pack;
}
