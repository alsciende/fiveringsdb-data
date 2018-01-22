<?php

namespace App\Entity;

use Alsciende\SerializerBundle\Annotation\Skizzle;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="labels", indexes={
 *          @ORM\Index(columns={"lang"})
 *     })
 *
 * @Skizzle(break="lang")
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Label
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
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, unique=false)
     *
     * @Skizzle\Field(type="string")
     */
    public $value;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=10, unique=false)
     *
     * @Skizzle\Field(type="string")
     */
    public $lang;
}
