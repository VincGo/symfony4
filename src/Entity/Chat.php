<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Gestion du chat
 *
 * @ORM\Entity(repositoryClass="App\Repository\ChatRepository")
 *
 * @category PHP
 * @package  App\Entity
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */
class Chat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Veuillez ne pas laisser votre message vide.")
     * @Assert\Length(
     *     max=10000,
     *     maxMessage="Message trop long. (10 000 caractères maximum)"
     * )
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $team;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     */
    private $publishedAt;

    /**
     * Chat constructor.
     */
    public function __construct()
    {
        $this->publishedAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getPseudo(): User
    {
        return $this->pseudo;
    }

    /**
     * @param User $pseudo
     */
    public function setPseudo(User $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param string $team
     */
    public function setTeam(string $team): void
    {
        $this->team = $team;
    }

    public function getPublishedAt(): \DateTime
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTime $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }
}
