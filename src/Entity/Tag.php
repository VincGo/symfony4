<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 01/03/2018
 * Time: 07:59
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity()
 *
 * @category PHP
 * @package  App\Entity
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */
 class Tag implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): string
    {
        // This entity implements JsonSerializable (http://php.net/manual/en/class.jsonserializable.php)
        // so this method is used to customize its JSON representation when json_encode()
        // is called, for example in tags|json_encode (app/Resources/views/form/fields.html.twig)

        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}